<?php

namespace App\Services\products;

use App\Models\Product;
use App\Services\products\contracts\ProductInterface;
use App\Trait\ProductExcludedTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LogicException;

class ProductService implements ProductInterface
{
    use ProductExcludedTrait;
    
    public function all()
    {
        try {

            $attributes = [
                'name',
                'id',
                'price',
                'current_stock',
                'min_stock',
                'created_at',
            ];
            
            $product = Product::select($attributes)
            ->orderByDesc('created_at')
            ->paginate(6);

            return $product;

        } catch (\Throwable) {
            throw new \Exception("Não foi possível carregar a lista de produtos. Por favor, tente novamente.");
        }
    }

    public function get(int $id)
    {
        try {

            $product = Product::findOrFail($id);   

            return response()->json([
                'data' => [
                    'product' => $product,
                    'category' => $product->category,
                ],
            ]);

        } catch (ModelNotFoundException) {
            throw new \Exception("Não encontrámos o produto solicitado.");
        }
        catch (\Throwable) {
            throw new \Exception("Não foi possível consultar o produto. Por favor, tente novamente.");
        }
    }

    public function update(Product $product, $data = []): void
    {
        try {
            
            $product->updateOrFail([
                'name' => $data['name'],
                'price' => $data['price'],
                'box_price' => $data['box_price'],
                'min_stock' => $data['min_stock'],
                'category_id' => $data['category_id'],
            ]);

        } catch (\Throwable) {
            throw new \Exception("Não foi possível actualizar o produto. Por favor, tente novamente.");
            
        }
    }

    public function save($data = []): Product
    {
        try {

            return Product::create([
                'name' => $data['name'],
                'price' => $data['price'],
                'box_price' => $data['box_price'],
                'current_stock' => $data['current_stock'] ?? 0,
                'min_stock' => $data['min_stock'],
                'category_id' => $data['category_id'],
                /* 'user_id' => Auth::user()->id, */
            ]);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage()/* 'Não foi possível guardar o produto. Por favor, tente novamente.' */);
        }
    }

    public function delete(Product $product): void
    {
        try {

            $product->delete();

        } catch (LogicException) {
            throw new \Exception("Não foi possível eliminar o produto. Por favor, tente novamente.");
            
        } catch (\Throwable) {
            throw new \Exception("Não foi possível eliminar o produto. Por favor, tente novamente.");
            
        }
    }
}