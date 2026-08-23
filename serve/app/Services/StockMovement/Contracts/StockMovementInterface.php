<?php

namespace App\Services\StockMovement\Contracts;

use App\Models\StockMovement;

interface StockMovementInterface
{
    /**
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function save($data = []): void;

    /**
     * @param array $data  
     * @param StockMovement $stockMovement
     * @return void
     * @throws \Exception
     */
    public function update(StockMovement $stockMovement, $data = []): void;
}