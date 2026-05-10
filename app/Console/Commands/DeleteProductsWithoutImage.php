<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DeleteProductsWithoutImage extends Command
{
    protected $signature = 'products:delete-without-image';
    protected $description = '商品画像が存在しない商品を削除する';

    public function handle()
    {
        $products = Product::whereNull('image_path')
            ->orWhere('image_path', '')
            ->orWhere(function ($query) {
                $query->whereNotNull('image_path')
                    ->where('image_path', '!=', '')
                    ->whereRaw('1 = 1'); // placeholder
            })
            ->get();

        $deleted = 0;
        foreach ($products as $product) {
            if (empty($product->image_path)) {
                $product->delete();
                $deleted++;
                continue;
            }
            if (!Storage::disk('public')->exists($product->image_path)) {
                $product->delete();
                $deleted++;
            }
        }
        $this->info("削除件数: {$deleted}");
        return 0;
    }
}
