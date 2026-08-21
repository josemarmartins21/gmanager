<?php

namespace App\Services\Sales;

use App\Models\Product;
use App\Services\Sales\Contracts\CartSessionInterface;

class CartSessionService implements CartSessionInterface
{
    public function add(int $product_id, int $qty): void
    {
        try {

    
            if ($qty <= 0) {
                throw new \Exception('A quantidade deve ser maior que zero.');
            }

            $cart = session('sale.cart', []);

            $product = Product::find($product_id);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['qty'] += $qty;
            } else {
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
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