<?php

namespace Database\Seeders;

use App\Models\Permission;
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
                'name' => 'criar venda',
                'guard_name' => 'web',
            ],
            [
                'name' => 'visualizar vendas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'excluir venda',
                'guard_name' => 'web',
            ],
            [
                'name' => 'alterar status da venda',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar venda',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar venda definitivamente',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restaurar venda apagada',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restaurar vendas apagadas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar todas as vendas definitivamente',
                'guard_name' => 'web',
            ],
            [
                'name' => 'visualizar vendas apagadas',
                'guard_name' => 'web',
            ]
        ]);
        
        Permission::factory()->createMany([
            [
                'name' => 'visualizar movimentações de estoque',
                'guard_name' => 'web',
            ],
            [
                'name' => 'actualizar estoque',
                'guard_name' => 'web',
            ],
            [
                'name' => 'editar movimentação de estoque',
                'guard_name' => 'web',
            ],
            [
                'name' => 'visualizar movimentações de estoque apagadas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restaurar movimentação de estoque apagada',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restaurar movimentações de estoque apagadas',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar movimentação de estoque definitivamente',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar todas as movimentações de estoque definitivamente',
                'guard_name' => 'web',
            ],
        ]);
    
        Permission::factory()->createMany([
            [
                'name' => 'criar producto',
                'guard_name' => 'web',
            ],
            [
                'name' => 'visualizar productos',
                'guard_name' => 'web',
            ],
            [
                'name' => 'editar producto',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar producto',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar producto definitivamente',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restaurar producto apagado',
                'guard_name' => 'web',
            ],
            [
                'name' => 'restaurar productos apagados',
                'guard_name' => 'web',
            ],
            [
                'name' => 'apagar todos os productos definitivamente',
                'guard_name' => 'web',
            ],
            [
                'name' => 'visualizar productos apagados',
                'guard_name' => 'web',
            ],
            [
                'name' => 'gerar PDFs',
                'guard_name' => 'web',
            ],
        ]);
    }
}
