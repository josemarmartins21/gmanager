<?php

namespace App\Strategies\Recycles;

use App\Exceptions\EmptyRecycleException;
use App\Models\Sale;
use App\Strategies\Recycles\Contracts\RecycleInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class SaleRecycle implements RecycleInterface   
{
    /**
     * @return LengthAwarePaginator
    * @throws \Exception
    */
    public function allTrashed(): LengthAwarePaginator 
    {
        try {
            
            return Sale::onlyTrashed()->latest()->paginate(6);

        } catch (\Throwable) {
            throw new \Exception("Não foi passível carregar as vendas na reciclagem. Por favor, tente novamente.");
        }
    }

    /**
     * @param Sale
     * 
     * @return void
     * @throws \Exception
     */

    public function restore(string $id): void 
    {
        try {

            $Sale = Sale::onlyTrashed()->findOrFail($id);

            $Sale->restore();

        } catch (ModelNotFoundException) {
            throw new \Exception("Esta venda não se encontra na reciclagem.");

        } catch (\Throwable) {
            throw new \Exception("Não foi passível restaurar o venda. Por favor, tente novamente.");
        }
    }

    public function restoreAll()
    {
        try {
            
            $this->hasExcluded();

            Sale::onlyTrashed()->restore();

        } catch (EmptyRecycleException $e) {
            throw new \Exception($e->getMessage());
            
        } catch (\Throwable) {
            throw new \Exception("Não foi passível restaurar as vendas. Por favor, tente novamente.");
            
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function permanentlyDelete(string $id): void
    {
        try {

            $Sale = Sale::onlyTrashed()->findOrFail($id);

            $Sale->forceDelete();
            
        } catch (ModelNotFoundException) {
            throw new \Exception("Esta venda não se encontra na reciclagem.");
            
        } catch (\Throwable) {
            throw new \Exception("Não foi passível eliminar definitivamente a venda. Por favor, tente novamente.");
            
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

            Sale::onlyTrashed()->forceDelete();

        } catch (EmptyRecycleException $e) {
            throw new \Exception($e->getMessage());
            
        } catch (\Throwable) {
            throw new \Exception("Não foi passível eliminar todas as registas. Por favor, tente novamente.");
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function hasExcluded(): void
    {
        $nbExcluded = Sale::onlyTrashed()->count();

        if ($nbExcluded === 0) {
            throw new EmptyRecycleException("A reciclagem está vazia."); 
        }
    }
}
