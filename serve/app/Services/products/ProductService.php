<?php

namespace App\Services\products;

use App\Models\Product;
use App\Services\products\contracts\ProductInterface;

class ProductService implements ProductInterface
{
    public function all()
    {
        try {

            $attributes = [
                'products.name',
                'products.price',
                'products.current_stock',
                'categories.name as category_name',
                'products.created_at',
            ];
            
            $product = Product::select($attributes)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderByDesc('products.created_at')
            ->paginate(8);

            return response()->json([
                'data' => $product,
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function get(int $id)
    {
        try {

            $product = Product::find($id);
            
            if (! $product) {
                throw new \Exception('Producto não encontrado');
            }    

            return response()->json([
                'data' => [
                    'product' => $product,
                    'category' => $product->category,
                ],
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update(Product $product, $data = [])
    {
        
    }

    public function save($data = [])
    {
        
    }

    public function delete(Product $product)
    {
        
    }
}