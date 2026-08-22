<?php

namespace App\Services\Sales\Contracts;

interface SaleInterface
{
    /**
     * @throws \Exception
     * @return void
     */
    public function save($saleItems = [], $saleDetails = []);
}