<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sales\SaleRequest;
use App\Models\Sale;
use App\Services\Sales\Contracts\CartSessionInterface;
use App\Services\Sales\Contracts\SaleInterface;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        private SaleInterface $saleService,
        private CartSessionInterface $cartService,
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
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request)
    {
        try {

            $saleDetails = $request->only(['note', 'total_payed']);
            $saleItems = $this->cartService->getAllItems();
            
            $this->saleService->save($saleItems, $saleDetails);

            $this->cartService->flushAll();

            return response()->json([
                'message' => "Venda finalizada com sucesso!",
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
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
