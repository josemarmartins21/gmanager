<?php

namespace App\Trait;

use App\Exceptions\EmptyRecycleException;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

trait ProductExcludedTrait
{
    /**
     * @return LengthAwarePaginator
    * @throws \Exception
    */
    public function allTrashed(): LengthAwarePaginator 
    {
        try {
            
            return Product::onlyTrashed()->latest()->paginate(10);

        } catch (\Throwable) {
            throw new \Exception("Erro ao buscar productos na reciclagem");
        }
    }

    /**
     * @param Product
     * 
     * @return void
     * @throws \Exception
     */

    public function restore(string $id): void 
    {
        try {

            $product = Product::onlyTrashed()->findOrFail($id);

            $product->restore();

        } catch (ModelNotFoundException) {
            throw new \Exception("Este producto não se encontra na lixeira");

        } catch (\Throwable) {
            throw new \Exception("Erro ao excluir o producto");
        }
    }

    public function restoreAll()
    {
        try {
            
            $this->hasExcluded();

            Product::onlyTrashed()->restore();

        } catch (EmptyRecycleException $e) {
            throw new \Exception($e->getMessage());
            
        } catch (\Throwable) {
            throw new \Exception("Erro ao restaurar os productos");
            
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function permanentlyDelete(string $id): void
    {
        try {

            $product = Product::onlyTrashed()->findOrFail($id);

            $product->forceDelete();
            
        } catch (ModelNotFoundException) {
            throw new \Exception("Este producto não se encontra na lixeira");
            
        } catch (\Throwable) {
            throw new \Exception("Erro ao excluir definitivamente o producto");
            
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function cleanAll(): void
    {
        try {

            $this->hasExcluded();

            Product::onlyTrashed()->forceDelete();

        } catch (EmptyRecycleException $e) {
            throw new \Exception($e->getMessage());
            
        } catch (\Throwable) {
            throw new \Exception("Erro ao excluir todos os registos");
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function hasExcluded(): void
    {
        $nbExcluded = Product::onlyTrashed()->count();

        if ($nbExcluded === 0) {
            throw new EmptyRecycleException("A lixeira se encontra vazia!"); 
        }
    }
}
