<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::factory()->createMany([
            [
                'name' => 'sale:create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sale:read',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sale:update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sale:delete',
                'guard_name' => 'web',
            ],
        ]);
    
        Permission::factory()->createMany([
            [
                'name' => 'products:create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'products:read',
                'guard_name' => 'web',
            ],
            [
                'name' => 'products:update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'products:delete',
                'guard_name' => 'web',
            ],
            [
                'name' => 'products:force-delete',
                'guard_name' => 'web',
            ],
        ]);
        
        Permission::factory()->createMany([
            [
                'name' => 'category:create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'category:read',
                'guard_name' => 'web',
            ],
            [
                'name' => 'category:update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'category:delete',
                'guard_name' => 'web',
            ]
        ]);

    }
}
