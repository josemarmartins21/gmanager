<?php

namespace App\Services\Sales\Contracts;

interface CartSessionInterface
{
    /**
     * @return void
     * @throws \Exception
     */
    public function add(int $product_id, int $qty): void;
    
    /**
     * Clean all products from the session.
     * 
     * @return void
     * @throws \Exception
     */
    public function flushAll(): void;
    
    /**
     * @throws \Exception
    */
    public function getItem(string $id): ?array;

    /**
     * Clean a product from the session
     * 
     * @return void
     * @throws \Exception
     */
    public function removeItem(string $id): void;

    /**
     * @return array 
     * @throws \Exception
     */
    public function getAllItems(): array;
}