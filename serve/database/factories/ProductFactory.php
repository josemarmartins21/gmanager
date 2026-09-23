<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(10),
            'price' => fake()->randomFloat(0, 250, 1000),
            'box_price' => fake()->randomFloat(2, 2500, 1000),
            'current_stock' => fake()->numberBetween(20, 500),
            'min_stock' => fake()->numberBetween(5, 12),
            'category_id' => Category::all()->random()->id,
        ];
    }
}
