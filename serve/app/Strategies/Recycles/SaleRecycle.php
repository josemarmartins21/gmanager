<?php

namespace App\Strategies\Recycles;

use App\Exceptions\EmptyRecycleException;
use App\Factories\StockMovmentFactory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockMovement;
use App\Services\StockMovement\Contracts\StockMovementInterface;
use App\Services\StockMovement\StockMovementService;
use App\Strategies\Recycles\Contracts\RecycleInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

            $stockMovment = StockMovmentFactory::create();
            $sale = Sale::onlyTrashed()->findOrFail($id);

            DB::transaction(function () use ($sale, $stockMovment): void {
                $this->restoreStockAfterExclusion($sale, $stockMovment);

                $sale->forceDelete();
            });

            
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
            
            $stockMovment = StockMovmentFactory::create();

            DB::transaction(function () use ($stockMovment): void {
                $this->restoreStocksAfterExclusion($stockMovment);

                Sale::onlyTrashed()->forceDelete();
            });


        } catch (EmptyRecycleException $e) {
            throw new \Exception($e->getMessage());
            
        } catch (\Throwable $e) {
            Log::error("Erro ao excluir uma venda", [
                'message' => $e->getMessage(),
            ]);

            throw new \Exception("Não foi passível eliminar todas as vendas registas. Por favor, tente novamente.");
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

    private function restoreStockAfterExclusion(Sale $sale, StockMovementInterface $stockMovment)
    {
        foreach ($sale->saleItems as $saleItem) {
            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($saleItem->product_id);
                
            $stockMovment->save([
                'type' => 'Entrada',
                'note' => 'Uma venda foi excluida definitivamente',
                'total_units' => $saleItem->qty,
                'product_name' => $product->name,
                'product_id' => $product->id,
                'user_id' => Auth::user()->id,    
            ]);
        }
    }

    private function restoreStocksAfterExclusion(StockMovementInterface $stockMovment): void
    {
        $sales = Sale::onlyTrashed()->get();

        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $saleItem) {
                $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($saleItem->product_id);
                    
                $stockMovment->save([
                    'type' => 'Entrada',
                    'note' => 'Uma venda foi excluida definitivamente',
                    'total_units' => $saleItem->qty,
                    'product_name' => $product->name,
                    'product_id' => $product->id,
                    'user_id' => Auth::user()->id,    
                ]);
            }
        }

    }
}
