<?php

namespace App\Services\StockMovement\Contracts;

interface StockMovementInterface
{
    /**
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function save($data = []): void;
}