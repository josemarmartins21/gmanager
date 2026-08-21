<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saleItems = SaleItem::factory(6)->create();
        $total = 0;
        $isPayed = fake()->boolean(70);
        $randomPorcentPayed = (float) fake()->numberBetween(1, 10) / 9;

        foreach ($saleItems as $item) {
            $total += $item->subtotal;
        }

        Sale::create([
            'total' => $total,
            'status' => fake()->boolean(70),
            'note' => fake()->text(),
            'user_id' => User::all()->random()->id,
            'total_payed' => $isPayed ? $total : $total * $randomPorcentPayed,
        ])->saleItems()->saveMany($saleItems);
    }
}
