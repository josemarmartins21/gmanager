<?php

namespace App\Services\Sales;

use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use App\Models\Sale;
use App\Services\Sales\Contracts\SaleInterface;
use App\Trait\QuantityValidationTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class SaleService implements SaleInterface
{
    use QuantityValidationTrait;
    
    public function save($saleItems = [], $saleDetails = []): void
    {
        try {
            
            $this->checkIfHasProduct($saleItems);

            DB::transaction(function() use ($saleItems, $saleDetails) {
                $products = [];
                $total = 0;
                $totalPayed = $saleDetails['total_payed'] ?? 0;

                foreach ($saleItems as $item) {
                    $this->validateQuantity($item['qty']);

                    $products[$item['product_id']] = Product::query()->lockForUpdate()
                    ->findOrFail($item['product_id']);

                    $total += $products[$item['product_id']]->price * $item['qty'];
                }

                foreach ($products as $product) {
                    $itemQty = $saleItems[$product->id]['qty'];

                    $this->checkQuantity($product, $itemQty);
                    $product->decrement('current_stock', $itemQty);
                }

                $sale = Sale::create([
                    'total' => $total,
                    'total_payed' => $totalPayed,
                    'note' => $saleDetails['note'] ?? null,
                    'status' => $totalPayed >= $total,
                    /* 'user_id' => Auth::user()->id */
                ]);

                foreach ($saleItems as $item) {
                    $sale->saleItems()->create([
                        'qty' => $item['qty'],
                        'product_name' => $products[$item['product_id']]->name,
                        'product_id' => $products[$item['product_id']]->id,
                        'product_price' => $products[$item['product_id']]->price,
                        'subtotal' => $item['qty'] * $products[$item['product_id']]->price,
                    ]);
                }
            });

        } catch (InsufficientStockException $e) {
            throw new \Exception($e->getMessage());
        } catch (ModelNotFoundException) {
            throw new \Exception("Producto inválido inserido ao carrinho");
        } catch (EmptyCartException $th) {
            throw new \Exception($th->getMessage());
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }    
        
    }

    private function checkIfHasProduct($products = []): void
    {
        if (count($products) === 0) {
            throw new EmptyCartException("Carrinho vazio. Adicione ao menos um producto antes de finalizar a venda");
        }
    }
    
}