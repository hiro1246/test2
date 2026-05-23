<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseAccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_viewing_purchase_page_does_not_mark_product_as_sold(): void
    {
        /** @var User $seller */
        $seller = User::factory()->create();
        /** @var User $firstBuyer */
        $firstBuyer = User::factory()->create();

        $product = Product::factory()->create([
            'name' => '購入画面表示検証商品',
            'price' => 5000,
            'seller_user_id' => $seller->id,
            'buyer_user_id' => null,
            'is_sold' => false,
        ]);

        $this->actingAs($firstBuyer)
            ->get(route('products.purchase', $product))
            ->assertOk();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_sold' => false,
            'buyer_user_id' => null,
        ]);
    }

    public function test_second_account_cannot_access_purchase_page_when_product_is_reserved_by_another_user(): void
    {
        /** @var User $seller */
        $seller = User::factory()->create();
        /** @var User $firstBuyer */
        $firstBuyer = User::factory()->create();
        /** @var User $secondBuyer */
        $secondBuyer = User::factory()->create();

        $product = Product::factory()->create([
            'name' => '購入画面ブロック検証商品',
            'price' => 5000,
            'seller_user_id' => $seller->id,
            'buyer_user_id' => $firstBuyer->id,
            'is_sold' => true,
        ]);

        $response = $this->actingAs($secondBuyer)
            ->get(route('products.purchase', $product));

        $response->assertRedirect(route('products.show', $product));
        $response->assertSessionHas('status', 'この商品はすでに購入済みです。');
    }

    public function test_second_account_cannot_reach_checkout_when_product_is_reserved_by_another_user(): void
    {
        /** @var User $seller */
        $seller = User::factory()->create();
        /** @var User $firstBuyer */
        $firstBuyer = User::factory()->create();
        /** @var User $secondBuyer */
        $secondBuyer = User::factory()->create();

        $product = Product::factory()->create([
            'name' => '排他制御テスト商品',
            'price' => 5000,
            'seller_user_id' => $seller->id,
            'buyer_user_id' => $firstBuyer->id,
            'is_sold' => true,
        ]);

        $response = $this->actingAs($secondBuyer)
            ->from(route('products.purchase', $product))
            ->post(route('products.purchase.complete', $product), [
                'payment_method' => 'card',
            ]);

        $response->assertRedirect(route('products.purchase', $product));
        $response->assertSessionHasErrors([
            'purchase' => 'この商品はすでに購入済みです。他のユーザーが購入手続き中の可能性があります。',
        ]);
    }
}
