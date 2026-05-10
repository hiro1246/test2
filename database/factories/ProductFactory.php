<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'image_path' => null,
            'is_sold' => false,
        ];
    }

    public function sold(): self
    {
        return $this->state(fn (): array => [
            'is_sold' => true,
        ]);
    }
}
