<?php

namespace App\Strategies\Recycles;

use App\Exceptions\EmptyRecycleException;
use App\Models\StockMovement;
use App\Services\StockMovement\Contracts\StockMovementInterface;
use App\Strategies\Recycles\Contracts\RecycleInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockMovementRecycle implements RecycleInterface   
{
    /**
     * @return LengthAwarePaginator
    * @throws \Exception
    */
    public function allTrashed(): LengthAwarePaginator 
    {
        try {
            
            return StockMovement::onlyTrashed()->latest()->paginate(6);

        } catch (\Throwable $e) {
            Log::error("Erro ao listar movimentações de estoque excluidas", [
                'message' => $e->getMessage(),
            ]);

            throw new \Exception("Não foi passível carregar as movimentações de estoque na reciclagem. Por favor, tente novamente.");
        }
    }

    /**
     * @param stockMovement
     * 
     * @return void
     * @throws \Exception
     */

    public function restore(string $id): void 
    {
        try {

            $stockMovement = StockMovement::onlyTrashed()->findOrFail($id);

            $stockMovement->restore();

        } catch (ModelNotFoundException) {
            throw new \Exception("Esta movimentação de estoque não se encontra na reciclagem.");

        } catch (\Throwable $e) {
            Log::error("Erro ao restaurar movimentação de estoque", [
                'message' => $e->getMessage(),
            ]);

            throw new \Exception("Não foi passível restaurar a movimentação de estoque. Por favor, tente novamente.");
        }
    }

    public function restoreAll()
    {
        try {
            
            $this->hasExcluded();

            StockMovement::onlyTrashed()->restore();

        } catch (EmptyRecycleException $e) {
            throw new \Exception($e->getMessage());
            
        } catch (\Throwable $e) {
            Log::error("Erro ao restaurar movimentações de estoque", [
                'message' => $e->getMessage(),
            ]);

            throw new \Exception("Não foi passível restaurar as movimentações de estoque. Por favor, tente novamente.");
            
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function permanentlyDelete(string $id): void
    {
        try {

            $stockMovement = StockMovement::onlyTrashed()->findOrFail($id);

            $stockMovement->forceDelete();
            
        } catch (ModelNotFoundException) {
            throw new \Exception("Esta movimentação de estoque não se encontra na reciclagem.");
            
        } catch (\Throwable $e) {
            Log::error("Erro ao excluir definitivamente a movimentação de estoque", [
                'message' => $e->getMessage(),
            ]);

            throw new \Exception("Não foi possível eliminar definitivamente a movimentação de estoque. Por favor, tente novamente.");
            
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

            StockMovement::onlyTrashed()->forceDelete();

        } catch (EmptyRecycleException $e) {
            throw new \Exception($e->getMessage());
            
        } catch (\Throwable $e) {
            Log::error("Erro ao excluir as movimentações de estoque", [
                'message' => $e->getMessage(),
            ]);

            throw new \Exception("Não foi possível eliminar todos os registos. Por favor, tente novamente.");
        }
    }

    /**
    * @return void
    * @throws \Exception
    */
    public function hasExcluded(): void
    {
        $nbExcluded = StockMovement::onlyTrashed()->count();

        if ($nbExcluded === 0) {
            throw new EmptyRecycleException("A reciclagem está vazia."); 
        }
    }
}
