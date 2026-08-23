<?php

namespace App\Trait;

use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use InvalidArgumentException;

trait QuantityValidationTrait
{
    public function validateQuantity(int $qty): void
    {
        if ($qty <= 0) {
            throw new InvalidArgumentException('A quantidade deve ser maior que zero.');
        }
    }

    public function checkQuantity(Product $product, int $qty): void
    {
        $this->validateQuantity($qty);

        if ($product->current_stock < $qty) {
            throw new InsufficientStockException("Quantidade de {$product->name} insuficiente!");
        }
    }
}