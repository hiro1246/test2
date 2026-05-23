<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();
        $hasSellerColumn = Schema::hasColumn('products', 'seller_user_id');
        $hasBuyerColumn = Schema::hasColumn('products', 'buyer_user_id');

        return view('profile.show', [
            'user' => $user,
            'listedProducts' => $hasSellerColumn
                ? Product::query()->where('seller_user_id', $user->id)->latest('id')->get()
                : collect(),
            'purchasedProducts' => $hasBuyerColumn
                ? Product::query()->where('buyer_user_id', $user->id)->latest('id')->get()
                : collect(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.setup', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/\S/u'],
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                Rule::unique('users', 'email')->ignore($request->user()?->id),
            ],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'postal_code' => ['required', 'regex:/^\d{3}-?\d{4}$/'],
            'address' => ['required', 'string', 'max:255', 'regex:/\S/u'],
            'building_name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => 'ユーザー名は255文字以内で入力してください',
            'name.regex' => 'ユーザー名を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.unique' => 'このメールアドレスは既に使用されています',
            'profile_image.image' => 'プロフィール画像は画像ファイルを選択してください',
            'profile_image.mimes' => 'プロフィール画像はjpg、jpeg、png、webp形式でアップロードしてください',
            'profile_image.max' => 'プロフィール画像は2MB以下でアップロードしてください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号は123-4567形式で入力してください',
            'address.required' => '住所を入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'address.regex' => '住所を入力してください',
            'building_name.required' => '建物名を入力してください',
            'building_name.max' => '建物名は255文字以内で入力してください',
        ]);

        $user = $request->user();
        $profileImagePath = $user->profile_image_path;

        if ($request->hasFile('profile_image')) {
            if ($profileImagePath) {
                Storage::disk('public')->delete($profileImagePath);
            }

            $profileImagePath = $request->file('profile_image')->store('profile-images', 'public');
        }

        $user->update([
            'name' => trim($validated['name']),
            'email' => mb_strtolower(trim($validated['email'])),
            'profile_image_path' => $profileImagePath,
            'postal_code' => $this->formatPostalCode($validated['postal_code']),
            'address' => trim($validated['address']),
            'building_name' => trim($validated['building_name']),
        ]);

        return redirect()
            ->route('profile.show')
            ->with('status', 'プロフィールを更新しました。');
    }

    private function formatPostalCode(string $postalCode): string
    {
        $digits = preg_replace('/\D+/', '', $postalCode) ?? '';

        return substr($digits, 0, 3) . '-' . substr($digits, 3, 4);
    }
}
