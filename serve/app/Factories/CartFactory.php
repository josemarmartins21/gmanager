<?php

namespace App\Factories;

use App\Services\Sales\CartSessionService;
use App\Services\Sales\Contracts\CartSessionInterface;

class CartFactory
{
    public static function create(): CartSessionInterface
    {
        return new CartSessionService();
    }
}