<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class ProductController extends Controller
{
    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_image' => ['required_without:temporary_image_path', 'nullable', 'image', 'max:5120'],
            'temporary_image_path' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'condition' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'price' => ['required', 'integer', 'min:0'],
        ], [
            'product_image.required_without' => '商品画像を選択してください。',
            'product_image.image' => '画像ファイルを選択してください。',
            'product_image.max' => '画像は5MB以内でアップロードしてください。',
            'temporary_image_path.max' => '画像情報が不正です。',
            'category.required' => 'カテゴリーを選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'name.required' => '商品名を入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'brand.max' => 'ブランド名は255文字以内で入力してください。',
            'description.required' => '説明を入力してください。',
            'description.max' => '説明は2000文字以内で入力してください。',
            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は半角数字で入力してください。',
            'price.min' => '販売価格は0円以上で入力してください。',
        ]);

        $imagePath = null;

        if (isset($validated['product_image'])) {
            $imagePath = $validated['product_image']->store('products', 'public');
        } elseif (! empty($validated['temporary_image_path'])) {
            $temporaryPath = (string) $validated['temporary_image_path'];

            if (
                Str::startsWith($temporaryPath, 'products/tmp/')
                && Storage::disk('public')->exists($temporaryPath)
            ) {
                $extension = pathinfo($temporaryPath, PATHINFO_EXTENSION);
                $newName = (string) Str::uuid();
                $targetPath = 'products/' . $newName . ($extension !== '' ? '.' . $extension : '');

                Storage::disk('public')->move($temporaryPath, $targetPath);
                $imagePath = $targetPath;
            }
        }

        $rawPrice = preg_replace('/[^0-9]/', '', (string) $request->input('price', '0'));
        $price = (int) ($rawPrice !== '' ? $rawPrice : 0);

        $attributes = [
            'name' => trim($validated['name']),
            'brand' => trim((string) ($validated['brand'] ?? '')),
            'description' => trim((string) ($validated['description'] ?? '')),
            'price' => $price,
            'category' => $validated['category'],
            'condition' => $validated['condition'],
            'image_path' => $imagePath,
            'is_sold' => false,
        ];

        if (Schema::hasColumn('products', 'seller_user_id')) {
            $attributes['seller_user_id'] = $request->user()?->id;
        }

        $product = Product::create($attributes);

        return redirect()
            ->route('products.index')
            ->with('status', '商品を出品しました。');
    }

    public function uploadTemporaryImage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_image' => ['required', 'image', 'max:5120'],
        ], [
            'product_image.required' => '商品画像を選択してください。',
            'product_image.image' => '画像ファイルを選択してください。',
            'product_image.max' => '画像は5MB以内でアップロードしてください。',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first('product_image'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $imageFile = $request->file('product_image');

        if (! $imageFile) {
            return response()->json([
                'message' => '商品画像を選択してください。',
            ], 422);
        }

        $path = $imageFile->store('products/tmp', 'public');

        return response()->json([
            'path' => $path,
            'url' => asset('storage/' . $path),
            'name' => $imageFile->getClientOriginalName(),
        ]);
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $currentFilter = $request->query('list') === 'mylist' ? 'mylist' : 'all';
        $searchKeyword = trim((string) $request->query('keyword', ''));

        $productsQuery = Product::query()
            ->withCount('favoritedByUsers')
            ->whereNotNull('image_path')
            ->where('image_path', '<>', '')
            ->latest('id');

        if ($currentFilter === 'mylist' && $user) {
            $productsQuery->whereHas('favoritedByUsers', function ($query) use ($user): void {
                $query->where('users.id', $user->id);
            });
        }

        if ($searchKeyword !== '') {
            $productsQuery->where(function ($query) use ($searchKeyword): void {
                $query->where('name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('brand', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('description', 'like', '%' . $searchKeyword . '%');
            });
        }

        $products = $productsQuery->get();
        $likedProductIds = $user
            ? $user->favoriteProducts()->pluck('products.id')->all()
            : [];

        return view('products.index', [
            'products' => $products,
            'likedProductIds' => $likedProductIds,
            'currentFilter' => $currentFilter,
            'searchKeyword' => $searchKeyword,
        ]);
    }

    public function toggleFavorite(Request $request, Product $product): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => '認証が必要です。',
            ], 401);
        }

        $currentlyLiked = $user->favoriteProducts()
            ->where('products.id', $product->id)
            ->exists();

        if ($currentlyLiked) {
            $user->favoriteProducts()->detach($product->id);
        } else {
            $user->favoriteProducts()->syncWithoutDetaching([$product->id]);
        }

        $likesCount = $product->favoritedByUsers()->count();

        return response()->json([
            'liked' => ! $currentlyLiked,
            'likes_count' => $likesCount,
        ]);
    }

    public function show(Product $product): View
    {
        if (Schema::hasTable('comments')) {
            $product->loadCount('comments')->load('comments.user');
        } else {
            $product->setAttribute('comments_count', 0);
        }

        return view('products.show', [
            'product' => $product,
        ]);
    }

    public function purchase(Product $product): View
    {
        $destination = $this->resolveDestinationData(request(), $product);

        return view('products.purchase', [
            'product' => $product,
            'deliveryPostalCode' => $destination['postal_code'],
            'deliveryAddressLine' => $this->formatAddressLine($destination),
        ]);
    }

    public function purchaseDestination(Product $product): View
    {
        $destination = $this->resolveDestinationData(request(), $product);

        return view('products.purchase-destination', [
            'product' => $product,
            'destination' => $destination,
        ]);
    }

    public function updatePurchaseImage(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'product_image' => ['required', 'image', 'max:5120'],
        ], [
            'product_image.required' => '商品画像を選択してください。',
            'product_image.image' => '画像ファイルを選択してください。',
            'product_image.max' => '画像は5MB以内でアップロードしてください。',
        ]);

        if ($product->image_path && ! Str::startsWith($product->image_path, ['http://', 'https://', '/'])) {
            Storage::disk('public')->delete($product->image_path);
        }

        $path = $validated['product_image']->store('products', 'public');
        $product->image_path = $path;
        $product->save();

        return redirect()
            ->route('products.purchase', $product)
            ->with('status', '商品画像をアップロードしました。');
    }

    public function updatePurchaseDestination(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'postal_code' => ['required', 'regex:/^\d{3}-?\d{4}$/'],
            'address' => ['required', 'string', 'max:255', 'regex:/\S/u'],
            'building_name' => ['nullable', 'string', 'max:255'],
        ], [
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.regex' => '郵便番号は123-4567形式で入力してください。',
            'address.required' => '住所は必須です。',
            'address.max' => '住所は255文字以内で入力してください。',
            'address.regex' => '住所は必須です。',
            'building_name.max' => '建物名は255文字以内で入力してください。',
        ]);

        $request->session()->put($this->destinationSessionKey($product), [
            'postal_code' => $this->formatPostalCode($validated['postal_code']),
            'address' => trim($validated['address']),
            'building_name' => trim((string) ($validated['building_name'] ?? '')),
        ]);

        return redirect()
            ->route('products.purchase', $product)
            ->with('status', '送付先住所を更新しました。');
    }

    public function completePurchase(Request $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()
                ->route('login.show');
        }

        if ($product->is_sold) {
            return redirect()
                ->route('products.show', $product)
                ->with('status', 'この商品はすでに購入済みです。');
        }

        if (
            Schema::hasColumn('products', 'seller_user_id')
            && $product->seller_user_id !== null
            && $product->seller_user_id === $user->id
        ) {
            return redirect()
                ->route('products.show', $product)
                ->with('status', '自分が出品した商品は購入できません。');
        }

        $paymentMethod = (string) $request->input('payment_method', 'convenience');
        if (! in_array($paymentMethod, ['convenience', 'card'], true)) {
            $paymentMethod = 'convenience';
        }

        if ($paymentMethod !== 'card') {
            return $this->finalizePurchase($request, $product, $user->id, '商品を購入しました。');
        }

        $stripeSecret = (string) config('services.stripe.secret');

        if ($stripeSecret === '') {
            return redirect()
                ->route('products.purchase', $product)
                ->with('status', 'Stripe決済を利用するため、STRIPE_SECRET を .env に設定してください。');
        }

        try {
            $stripe = new StripeClient($stripeSecret);

            $checkoutSession = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => route('products.purchase.success', $product) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('products.purchase.cancel', $product),
                'client_reference_id' => (string) $user->id,
                'metadata' => [
                    'product_id' => (string) $product->id,
                    'buyer_user_id' => (string) $user->id,
                ],
                'line_items' => [[
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => 'jpy',
                        'unit_amount' => (int) $product->price,
                        'product_data' => [
                            'name' => (string) $product->name,
                            'description' => Str::limit((string) ($product->description ?? ''), 120),
                        ],
                    ],
                ]],
            ]);
        } catch (ApiErrorException $e) {
            return redirect()
                ->route('products.purchase', $product)
                ->with('status', '決済画面への接続に失敗しました。時間をおいて再度お試しください。');
        }

        if (! isset($checkoutSession->url) || $checkoutSession->url === '') {
            return redirect()
                ->route('products.purchase', $product)
                ->with('status', '決済画面URLの取得に失敗しました。');
        }

        return redirect()->away($checkoutSession->url);
    }

    public function purchaseSuccess(Request $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login.show');
        }

        if ($product->is_sold) {
            return redirect()
                ->route('profile.show')
                ->with('status', 'この商品はすでに購入済みです。');
        }

        if (
            Schema::hasColumn('products', 'seller_user_id')
            && $product->seller_user_id !== null
            && $product->seller_user_id === $user->id
        ) {
            return redirect()
                ->route('products.show', $product)
                ->with('status', '自分が出品した商品は購入できません。');
        }

        $sessionId = (string) $request->query('session_id', '');

        if ($sessionId === '') {
            return redirect()
                ->route('products.purchase', $product)
                ->with('status', '決済情報が見つかりません。もう一度お試しください。');
        }

        $stripeSecret = (string) config('services.stripe.secret');

        if ($stripeSecret === '') {
            return redirect()
                ->route('products.purchase', $product)
                ->with('status', '決済設定が未完了です。STRIPE_SECRET を .env に設定してください。');
        }

        try {
            $stripe = new StripeClient($stripeSecret);
            $checkoutSession = $stripe->checkout->sessions->retrieve($sessionId, []);
        } catch (ApiErrorException $e) {
            return redirect()
                ->route('products.purchase', $product)
                ->with('status', '決済結果の確認に失敗しました。');
        }

        $metadataProductId = (string) ($checkoutSession->metadata->product_id ?? '');
        $referenceUserId = (string) ($checkoutSession->client_reference_id ?? '');

        if (
            ($checkoutSession->payment_status ?? '') !== 'paid'
            || $metadataProductId !== (string) $product->id
            || $referenceUserId !== (string) $user->id
        ) {
            return redirect()
                ->route('products.purchase', $product)
                ->with('status', '決済が完了していないため購入を確定できません。');
        }

        return $this->finalizePurchase($request, $product, $user->id, 'Stripe決済が完了し、商品を購入しました。');
    }

    public function purchaseCancel(Product $product): RedirectResponse
    {
        return redirect()
            ->route('products.purchase', $product)
            ->with('status', '決済をキャンセルしました。');
    }

    public function storeComment(Request $request, Product $product): RedirectResponse
    {
        if (! Schema::hasTable('comments')) {
            return redirect()
                ->route('products.show', $product)
                ->with('comment_status', 'コメント機能は準備中です。');
        }

        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:255'],
        ], [
            'comment.required' => 'コメントは必須です。',
            'comment.string' => 'コメントは文字列で入力してください。',
            'comment.max' => 'コメントは255文字以内で入力してください。',
        ]);

        $product->comments()->create([
            'user_id' => $request->user()?->id,
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->route('products.show', $product)
            ->with('comment_status', 'コメントを受け付けました。');
    }

    private function destinationSessionKey(Product $product): string
    {
        return "purchase_destination.{$product->id}";
    }

    private function resolveDestinationData(Request $request, Product $product): array
    {
        $user = $request->user();

        $defaults = [
            'postal_code' => (string) ($user?->postal_code ?: ''),
            'address' => (string) ($user?->address ?: ''),
            'building_name' => (string) ($user?->building_name ?: ''),
        ];

        $saved = $request->session()->get($this->destinationSessionKey($product), []);

        return [
            'postal_code' => (string) ($saved['postal_code'] ?? $defaults['postal_code']),
            'address' => (string) ($saved['address'] ?? $defaults['address']),
            'building_name' => (string) ($saved['building_name'] ?? $defaults['building_name']),
        ];
    }

    private function formatAddressLine(array $destination): string
    {
        $addressLine = trim(($destination['address'] ?? '') . ' ' . ($destination['building_name'] ?? ''));

        return $addressLine;
    }

    private function formatPostalCode(string $postalCode): string
    {
        $digits = preg_replace('/\D+/', '', $postalCode) ?? '';

        return substr($digits, 0, 3) . '-' . substr($digits, 3, 4);
    }

    private function finalizePurchase(Request $request, Product $product, int $buyerUserId, string $statusMessage): RedirectResponse
    {
        $updateAttributes = [
            'is_sold' => true,
        ];

        if (Schema::hasColumn('products', 'buyer_user_id')) {
            $updateAttributes['buyer_user_id'] = $buyerUserId;
        }

        $product->update($updateAttributes);
        $request->session()->forget($this->destinationSessionKey($product));

        return redirect()
            ->route('profile.show')
            ->with('status', $statusMessage);
    }
}
