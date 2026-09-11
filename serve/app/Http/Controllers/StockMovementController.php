<?php

namespace App\Http\Controllers;

use App\Enums\StockOperations;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockMovement\StockMovementRequest;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockMovement\Contracts\StockMovementInterface;
use App\Trait\PermissionTrait;

class StockMovementController extends Controller
{
    use PermissionTrait;

    public function __construct(
        private StockMovementInterface $stockMovement,
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->hasAuthorization('visualizar movimentações de estoque');

            $stockMovements = $this->stockMovement->all();

            return view('stock-movments.index', compact('stockMovements'));

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $this->hasAuthorization('actualizar estoque');
    
            $products = Product::all('id', 'name');
            $allowedOperations = StockOperations::cases();
    
            return view('stock-movments.create', compact('products', 'allowedOperations'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockMovementRequest $request)
    {
        try {
            $this->hasAuthorization('actualizar estoque');

            $validated = $request->validated();
            
            $this->stockMovement->save($validated);

            return redirect(route('stock-movements.index'))->with('success', 'Estoque actualizado com sucesso!');

        } catch (\Exception $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        try {
            $this->hasAuthorization('editar movimentação de estoque');

            $products = Product::all('id', 'name');
            $allowedOperations = StockOperations::cases();

        return view('stock-movments.edit', compact('stockMovement', 'products', 'allowedOperations'));
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockMovement $stockMovement, StockMovementRequest $request)
    {
        try {

            $this->hasAuthorization('editar movimentação de estoque');

            $this->stockMovement->update($stockMovement, $request->validated());

            return redirect(route('stock-movements.index'));
            
        } catch (\Exception $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        //
    }
}
