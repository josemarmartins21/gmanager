<?php

namespace App\Services\StockMovement;

use App\Enums\StockOperations;
use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockMovement\Contracts\StockMovementInterface;
use App\Trait\QuantityValidationTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use ValueError;

class StockMovementService implements StockMovementInterface
{
    use QuantityValidationTrait;

    public function all(): LengthAwarePaginator
    {
        try {

            $attributes = [
                'stock_movements.product_name',
                'stock_movements.total_units',
                'stock_movements.box_qty',
                'stock_movements.type',
                'stock_movements.box_price',
                'stock_movements.id',
                'stock_movements.created_at',
                'users.name',
            ];

            return StockMovement::select($attributes)
            ->leftJoin('users', 'users.id', '=', 'stock_movements.user_id')
            ->orderByDesc('stock_movements.created_at')
            ->paginate(6);

        } catch (\Throwable) {
            throw new \Exception("Não foi possível carregar a lista de movimentos de stock. Por favor, tente novamente.");
            
        }
    }

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
                    'user_id' => Auth::user()->id,
                ]);

                $product->update([
                    'box_price' => $data['box_price'] ?? $product->box_price,
                ]);

            });

        } catch (InsufficientStockException $e) {
            throw new \Exception($e->getMessage());

        } catch (ModelNotFoundException) {
            throw new \Exception("Não encontrámos o produto solicitado.");

        } catch (\Throwable $e) {
            throw new \Exception("Não foi possível guardar o movimento de stock. Por favor, tente novamente.");

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

                $product->update([
                    'box_price' => $data['box_price'] ?? $product->box_price,
                ]);

               Log::debug('value', ['status' => $data['type']]);
            });
            
        } catch (ModelNotFoundException) {
            throw new \Exception("Não encontrámos o produto solicitado.");

        } 
        catch (InsufficientStockException $th) {
            throw new \Exception($th->getMessage());
        }
        catch (\Throwable) {
            throw new \Exception("Não foi possível actualizar o movimento de stock. Por favor, tente novamente.");
        }
    }

    private function updateStock(string $type, Product $product, int $qty): void
    {
        try {
            $type = StockOperations::from($type)->value;

            if ($type === 'Entrada') {
                $product->increment('current_stock', $qty);
            } else {
                $this->checkQuantity($product, $qty);
                $product->decrement('current_stock', $qty);
            }

        } catch (InsufficientStockException $e) {
            throw new \Exception($e->getMessage());

        } catch (ValueError) {
            throw new \Exception("O tipo de operação seleccionado não é válido.");

        } catch (\Throwable) {
            throw new \Exception("Não foi possível actualizar o stock. Por favor, tente novamente.");
        }
    }
}