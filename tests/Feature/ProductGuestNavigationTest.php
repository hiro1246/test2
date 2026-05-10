<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductGuestNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_products_index_and_open_product_detail(): void
    {
        $product = Product::factory()->create([
            'name' => 'ゲスト閲覧商品',
            'image_path' => 'products/guest-item.jpg',
        ]);

        $indexResponse = $this->get(route('products.index'));

        $indexResponse->assertOk();
        $indexResponse->assertSee('COACHTECH');
        $indexResponse->assertSee(route('products.show', $product), false);

        $detailResponse = $this->get(route('products.show', $product));

        $detailResponse->assertOk();
        $detailResponse->assertSee('ゲスト閲覧商品');
    }
}
