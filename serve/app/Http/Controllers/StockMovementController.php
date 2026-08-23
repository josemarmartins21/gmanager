<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMovement\StockMovementRequest;
use App\Models\StockMovement;
use App\Services\StockMovement\Contracts\StockMovementInterface;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function __construct(
        private StockMovementInterface $stockMovement,
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockMovementRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $this->stockMovement->save($validated);

            return response()->json([
                'data' => $validated,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMovement $stockMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMovement $stockMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMovement $stockMovement)
    {
        //
    }
}
