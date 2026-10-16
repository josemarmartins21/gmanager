<?php

namespace App\Factories;

use App\Services\StockMovement\Contracts\StockMovementInterface;
use App\Services\StockMovement\StockMovementService;

class StockMovmentFactory
{
    /**
     * @throws \Exception
     */
    public static function create(): StockMovementInterface
    {
        try {

            return new StockMovementService();

        } catch (\Throwable) {
            throw new \Exception("Algo deu errado, tente novamente");
        }
    }
}