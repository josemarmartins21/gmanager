<?php

namespace App\Services\StockMovement\Contracts;

use App\Models\StockMovement;
use Illuminate\Pagination\LengthAwarePaginator;

interface StockMovementInterface
{
    /**
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function save($data = []): void;

    /**
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function all(): LengthAwarePaginator;
    
    
    /**
     * @return void
     * @throws \Exception
     */
    public function delete(StockMovement $stockMovement);
}