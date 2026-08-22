<?php

namespace App\Services\Sales;

use App\Models\Product;
use App\Services\Sales\Contracts\CartSessionInterface;
use App\Trait\QuantityValidationTrait;

class CartSessionService implements CartSessionInterface
{
    use QuantityValidationTrait;

    public function add(int $product_id, int $qty): void
    {
        try {    
            
            $product = Product::findOrFail($product_id);
            $this->validateQuantity($qty);

            $cart = session('sale.cart', []);

            if (isset($cart[$product->id])) {
                $newQty = $cart[$product->id]['qty'] + $qty;
                $this->checkQuantity($product, $newQty);
                
                $cart[$product->id]['qty'] = $newQty;
            } else {
                $this->checkQuantity($product, $qty);

                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'qty' => $qty,
                ];
            }

            session()->put('sale.cart', $cart);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getItem(string $id): ?array
    {
        try {
            
            $cart = session('sale.cart', []);

            return $cart[$id] ?? null;

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getAllItems(): array
    {
        try {
            
            return session('sale.cart', []);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
  
    public function removeItem(string $id): void
    {
        try {

            $cart = session('sale.cart', []);

            if (! isset($cart[$id])) {
                throw new \Exception("Este produto não se encontra no carrinho!");
            }
            
            unset($cart[$id]);

            session()->put('sale.cart', $cart);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function flushAll(): void
    {
        try {

            session()->forget('sale.cart');

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}