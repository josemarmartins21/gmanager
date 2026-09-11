<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first();

        $user->categories()->createMany([
            [
                'name' => 'Cerveja',
            ], [
                'name' => 'Gasosa'
            ], [
                'name' => 'Vinho',
            ], [
                'name' => 'Cigarro'
            ]
        ]);
    }
}
