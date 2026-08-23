<?php

namespace App\Services\StockMovement;

use App\Enums\StockOperations;
use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockMovement\Contracts\StockMovementInterface;
use App\Trait\QuantityValidationTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use ValueError;

class StockMovementService implements StockMovementInterface
{
    use QuantityValidationTrait;

    public function save($data = []): void
    {
        try {

            DB::transaction(function() use ($data) {
                $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($data['product_id']);

                $qty = $data['box_qty'] ? $data['box_qty'] * $data['units_per_box'] : $data['total_units'];
                $this->updateStock($data['type'], $product, $qty);

                StockMovement::create([
                    'type' => $data['type'],
                    'box_qty' => $data['box_qty'] ?? 0,
                    'units_per_box' => $data['units_per_box'] ?? 0,
                    'note' => $data['note'],
                    'total_units' => $qty,
                    'product_name' => $product->name,
                    'product_id' => $product->id,
                    'box_price' => $data['box_price'],
                ]);

            });

        } catch (InsufficientStockException $e) {
            throw new \Exception($e->getMessage());

        } catch (ModelNotFoundException) {
            throw new \Exception("Producto não encontrado!");

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());

        }
    }

    public function update(StockMovement $stockMovement, $data = []): void
    {
        try {

            DB::transaction(function() use ($stockMovement, $data) {
                $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($data['product_id']);

                $qty = $data['box_qty'] ? $data['box_qty'] * $data['units_per_box'] : $data['total_units'];
                $this->updateStock($data['type'], $product, $qty);

                $stockMovement->update([
                    'type' => $data['type'],
                    'box_qty' => $data['box_qty'] ?? 0,
                    'units_per_box' => $data['units_per_box'] ?? 0,
                    'note' => $data['note'],
                    'total_units' => $qty,
                    'product_name' => $product->name,
                    'product_id' => $product->id,
                    'box_price' => $data['box_price'],
                ]);

               Log::debug('value', ['status' => $data['type']]);
            });
            
        } catch (ModelNotFoundException) {
            throw new \Exception("Producto não encontrado!");

        } 
        catch (InsufficientStockException $th) {
            throw new \Exception($th->getMessage());
        }
        catch (\Throwable $th) {
            throw new \Exception("Erro ao actualizar a movimentação de estoque");
        }
    }

    private function updateStock(string $type, Product $product, int $qty): void
    {
        try {
            $type = StockOperations::from($type)->value;

            if ($type === 'IN') {
                $product->increment('current_stock', $qty);
            } else {
                $this->checkQuantity($product, $qty);
                $product->decrement('current_stock', $qty);
            }

        } catch (InsufficientStockException) {
            throw new InsufficientStockException("Ok, mas a quantidade actual deste producto é inferior a quantidade que deseja diminuir para ajustar");

        } catch (ValueError) {
            throw new \Exception("Tipo de operação inválida");

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}