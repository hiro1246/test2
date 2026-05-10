<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_products_index(): void
    {
        $response = $this->get('/products');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_see_products_with_name_and_image(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Product::factory()->create([
            'name' => 'テスト商品A',
            'image_path' => 'products/item-a.jpg',
        ]);

        Product::factory()->create([
            'name' => 'テスト商品B',
            'image_path' => null,
        ]);

        $response = $this->actingAs($user)->get('/products');

        $response->assertOk();
        $response->assertSee('商品一覧');
        $response->assertSee('テスト商品A');
        $response->assertSee('テスト商品B');
        $response->assertSee('products/item-a.jpg');
    }

    public function test_sold_badge_is_shown_only_for_sold_products(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Product::factory()->sold()->create([
            'name' => '購入済み商品',
        ]);

        Product::factory()->create([
            'name' => '未購入商品',
        ]);

        $response = $this->actingAs($user)->get('/products');

        $response->assertOk();
        $response->assertSee('購入済み商品');
        $response->assertSee('未購入商品');
        $response->assertSee('<span class="sold-badge">Sold</span>', false);
        $this->assertSame(1, substr_count($response->getContent(), '<span class="sold-badge">Sold</span>'));
    }

    public function test_products_index_shows_empty_state_when_no_products(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/products');

        $response->assertOk();
        $response->assertSee('表示できる商品がまだありません。');
    }

    public function test_favorite_endpoint_toggles_like_on_second_click(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()->create();

        $firstResponse = $this->actingAs($user)
            ->postJson(route('products.favorites.toggle', $product));

        $firstResponse->assertOk();
        $firstResponse->assertJson([
            'liked' => true,
            'likes_count' => 1,
        ]);

        $secondResponse = $this->actingAs($user)
            ->postJson(route('products.favorites.toggle', $product));

        $secondResponse->assertOk();
        $secondResponse->assertJson([
            'liked' => false,
            'likes_count' => 0,
        ]);

        $this->assertDatabaseCount('favorites', 0);
    }
}
