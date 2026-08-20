<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SaleItem>
 */
class SaleItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = fake()->numberBetween(1, 20);
        $product = Product::all()->random();

        return [
            'qty' => $qty,
            'product_name' => fake()->word(),
            'subtotal' => $qty *  $product->price,
            'product_id' => $product->id,
            'product_price' => $product->price,
        ];
    }
}
