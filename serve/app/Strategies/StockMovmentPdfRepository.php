<?php

namespace App\Strategies;

use App\Models\StockMovement;
use App\Strategies\Contracts\PdfRepository;

class StockMovmentPdfRepository implements PdfRepository
{
    public function all()
    {
        try {
             $attributes = [
                'stock_movements.product_name',
                'stock_movements.total_units',
                'stock_movements.box_qty',
                'stock_movements.type',
                'stock_movements.box_price',
                'stock_movements.id',
                'stock_movements.created_at',
                'users.name',
                'products.box_price as prod_box_price',
                'products.price as prod_unit_price',
                'products.current_stock',
            ];
                        
            return StockMovement::select($attributes)
            ->join('products', 'products.id', '=', 'stock_movements.product_id')
            ->leftJoin('users', 'users.id', '=', 'stock_movements.user_id')
            ->orderByDesc('stock_movements.created_at')
            ->get();

        } catch (\Throwable) {
            throw new \Exception("Erro ao gerar o PDF" /* $e->getMessage() */);
            
        }
    }
}