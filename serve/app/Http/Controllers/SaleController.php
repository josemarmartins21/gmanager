<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sales\SaleRequest;
use App\Models\Sale;
use App\Services\Sales\Contracts\CartSessionInterface;
use App\Services\Sales\Contracts\SaleInterface;

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
        try {

            $sales = $this->saleService->all();

            return response()->json([
                'data' => $sales
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
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

        } catch (\Exception $th) {
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
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        try {
            $this->saleService->delete($sale);

            return response()->json([
                'message' => 'Venda excluida com sucesso!'
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
