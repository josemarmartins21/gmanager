<?php

namespace App\Services\Sales\Contracts;

use App\Models\Sale;
use Illuminate\Pagination\LengthAwarePaginator;

interface SaleInterface
{
    /**
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function all(): LengthAwarePaginator;

    /**
     * @throws \Exception
     * @return void
     */
    public function save($saleItems = [], $saleDetails = []);
   
    /**
     * @throws \Exception
     * @return void
     */
    public function delete(Sale $sale): void;
}