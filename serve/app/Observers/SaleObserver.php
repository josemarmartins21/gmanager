<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     */
    public function created(Sale $sale): void
    {
        Log::info('Venda registada com sucesso.', [
            'action' => 'criada',
            'sale_id' => $sale->id,
            'total' => $sale->total,
            'user_name' => User::find($sale->user_id)?->name,
            'user_id' => $sale->user_id,
        ]);
    }
    
    public function creating(Sale $sale): void
    {
        Log::info('A iniciar o registo da venda.', [
            'action' => 'criando',
            'sale_id' => $sale->id,
            'total' => $sale->total,
            'user_name' => User::find($sale->user_id)?->name,
            'user_id' => $sale->user_id,
        ]);
    }
   
    /**
     * Handle the Sale "deleted" event.
     */
    public function deleted(Sale $sale): void
    {
        Log::info('Venda eliminada com sucesso.', [
            'action' => 'eliminada',
            'total' => $sale->total,
            'products' => $this->productsName($sale),
            'user_name' => User::find($sale->user_id)?->name,
            'user_id' => $sale->user_id,
        ]);
    }
    
    public function deleting(Sale $sale): void
    {
        Log::info('A iniciar a eliminação da venda.', [
            'action' => 'eliminando',
            'total' => $sale->total,
            'products' => $this->productsName($sale),
            'user_name' => User::find($sale->user_id)?->name,
            'user_id' => $sale->user_id,
        ]);
    }

    /**
     * Handle the Sale "restored" event.
     */
    public function restored(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     */
    public function forceDeleted(Sale $sale): void
    {
        //
    }

    private function productsName(Sale $sale): array
    {
        $productsName = [];

        foreach ($sale->saleItems as $saleItem) {
            $productsName[] = $saleItem->product_name;
        }

        return $productsName;
    }
}
