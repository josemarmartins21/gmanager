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
            throw new \Exception("Não foi possível carregar os produtos na reciclagem. Por favor, tente novamente.");
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
            throw new \Exception("Este produto não se encontra na reciclagem.");

        } catch (\Throwable) {
            throw new \Exception("Não foi possível restaurar o produto. Por favor, tente novamente.");
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
            throw new \Exception("Não foi possível restaurar os produtos. Por favor, tente novamente.");
            
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
            throw new \Exception("Este produto não se encontra na reciclagem.");
            
        } catch (\Throwable) {
            throw new \Exception("Não foi possível eliminar definitivamente o produto. Por favor, tente novamente.");
            
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
            throw new \Exception("Não foi possível eliminar todos os registos. Por favor, tente novamente.");
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
            throw new EmptyRecycleException("A reciclagem está vazia."); 
        }
    }
}
