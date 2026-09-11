<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //User::factory(5)->create();
        
        $user = User::factory()->create([
            'name' => 'josimar',
            'email' => 'josemar@email.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('admin');
        $user->syncPermissions(Permission::all());
    }
}
