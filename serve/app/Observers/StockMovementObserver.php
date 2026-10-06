<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class StockMovementObserver
{
    /**
     * Handle the StockMovement "created" event.
     */
    public function created(StockMovement $stockMovement): void
    {
        $product = Product::find($stockMovement->product_id);
        
        Log::info('Movimentação de stock registada com sucesso.', [
            'action' => 'criada',
            'stock_movement_id' => $stockMovement->id,
            'product_name' => $product->name,
            'user_name' => User::find($stockMovement->user_id)?->name,
            'user_id' => $stockMovement->user_id,
        ]);
    }
    
    public function creating(StockMovement $stockMovement): void
    {
        $product = Product::find($stockMovement->product_id);

        Log::info('A iniciar o registo da movimentação de stock.', [
            'action' => 'criando',
            'stock_movement_id' => $stockMovement->id,
            'product_name' => $product->name,
            'user_name' => User::find($stockMovement->user_id)?->name,
            'user_id' => $stockMovement->user_id,
        ]);
    }

    public function updated(StockMovement $stockMovement): void
    {
        $product = Product::find($stockMovement->product_id);

        Log::info('Movimentação de stock actualizada com sucesso.', [
            'action' => 'actualizada',
            'stock_movement_id' => $stockMovement->id,
            'product_name' => $product->name,
            'user_name' => User::find($stockMovement->user_id)?->name,
            'user_id' => $stockMovement->user_id,
        ]);
    }
    
    public function updating(StockMovement $stockMovement): void
    {
        $product = Product::find($stockMovement->product_id);

        Log::info('A iniciar a actualização da movimentação de stock.', [
            'action' => 'actualizando',
            'stock_movement_id' => $stockMovement->id,
            'product_name' => $product->name,
            'user_name' => User::find($stockMovement->user_id)?->name,
            'user_id' => $stockMovement->user_id,
        ]);
    }

    /**
     * Handle the StockMovement "deleted" event.
     */
    public function deleted(StockMovement $stockMovement): void
    {
        $product = Product::find($stockMovement->product_id);

        Log::info('Movimentação de stock eliminada com sucesso.', [
            'action' => 'eliminada',
            'total' => $product->price * $stockMovement->total_units ?? 0,
            'type' => $stockMovement->type,
            'product_name' => $product->name,
            'user_name' => User::find($stockMovement->user_id)?->name,
            'user_id' => $stockMovement->user_id,
        ]);
    }

    /**
     * Handle the StockMovement "restored" event.
     */
    public function restored(StockMovement $stockMovement): void
    {
        //
    }

    /**
     * Handle the StockMovement "force deleted" event.
     */
    public function forceDeleted(StockMovement $stockMovement): void
    {
        //
    }
}
