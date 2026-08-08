<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionSales = Permission::factory()->createMany([
            [
                'name' => 'sales:create',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sales:read',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sales:update',
                'guard_name' => 'web',
            ],
            [
                'name' => 'sales:delete',
                'guard_name' => 'web',
            ],
        ]);
    
        $permissionProducts = Permission::factory()->createMany([
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
            ]
        ]);

        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->syncPermissions($permissionSales);
        $managerRole->syncPermissions($permissionProducts);

        $defaultRole = Role::where('name', 'default')->first();
        $defaultRole->givePermissionTo('sales:read');
        $defaultRole->givePermissionTo('sales:create');
        $defaultRole->givePermissionTo('products:read');

    }
}
