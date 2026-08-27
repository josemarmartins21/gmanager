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
                'products.name',
                'products.price',
                'products.current_stock',
                'products.box_price',
                'categories.name as category_name',
                'products.created_at',
            ];
            
            $product = Product::select($attributes)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderByDesc('products.created_at')
            ->paginate(8);

            return $product;

        } catch (\Throwable) {
            throw new \Exception("Erro ao carrgar os produtos. Tente novamente");
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
            throw new \Exception("Produto não encontrado");
        }
        catch (\Throwable) {
            throw new \Exception("Erro ao buscar o produto. Tente novamente");
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
            throw new \Exception("Erro ao atualizar o produto");
            
        }
    }

    public function save($data = []): Product
    {
        try {

            return Product::create([
                'name' => $data['name'],
                'price' => $data['price'],
                'box_price' => $data['box_price'],
                'current_stock' => $data['current_stock'],
                'min_stock' => $data['min_stock'],
                'category_id' => $data['category_id'],
                /* 'user_id' => Auth::user()->id, */
            ]);

        } catch (\Throwable) {
            throw new \Exception('Erro ao salvar o produto');
        }
    }

    public function delete(Product $product): void
    {
        try {

            $product->delete();

        } catch (LogicException) {
            throw new \Exception("Erro ao excluir o producto");
            
        } catch (\Throwable) {
            throw new \Exception("Erro ao excluir o producto");
            
        }
    }
}