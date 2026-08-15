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
            'price' => fake()->randomFloat(2, 1, 100),
            'box_price' => fake()->randomFloat(2, 1, 100),
            'current_stock' => fake()->numberBetween(0, 100),
            'min_stock' => fake()->numberBetween(1, 5),
            'category_id' => Category::all()->random()->id,
        ];
    }
}
