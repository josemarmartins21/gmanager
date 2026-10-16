<?php

namespace App\Factories;

use App\Strategies\Recycles\Contracts\RecycleInterface;
use App\Strategies\Recycles\ProductRecycle;
use App\Strategies\Recycles\SaleRecycle;
use App\Strategies\Recycles\StockMovementRecycle;
use Illuminate\Support\Facades\Log;
use UnhandledMatchError;

class RecycleFactory
{
    /**
     * @throws \Exception
     */
    public static function create(string $pdfType): RecycleInterface
    {
        try {

            return match ($pdfType) {
                'products' => new ProductRecycle(),
                'sales' => new SaleRecycle(),
                'stock-movement' => new StockMovementRecycle(),
            };

        } catch (UnhandledMatchError) {
            throw new \Exception("Tipo de exclusão indisponível");
        } catch (\Throwable $e) {
            Log::error('Erro ao selecionar reciclagem', [
                'message' => $e->getMessage(),
            ]);
            
            throw new \Exception("Erro ao excluir o item");
        }
    }
}