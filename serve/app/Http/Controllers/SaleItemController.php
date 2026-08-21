<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Sales\Contracts\CartSessionInterface;
use Illuminate\Http\Request;

class SaleItemController extends Controller
{
    public function __construct(
        private CartSessionInterface $saleItemService,
    )
    {}

    public function index()
    {
        try {
            
            $items = $this->saleItemService->getAllItems();

            return response()->json([
                'data' => $items,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            
            $item = $this->saleItemService->getItem($id);

            return response()->json([
                'data' => $item
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function store(Product $product, Request $request)
    {
        try {

            $this->validate($request);
        
            $this->saleItemService->add($product->id, $request->qty);

            return response()->json([
                'message' => 'Item adicionado com sucesso!',
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|numeric|integer|exists:products,id',
            ]);

            $this->saleItemService->removeItem($request->id);

            return response()->json([
                'message' => 'Item excluido com sucesso',
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function removeAll()
    {
        try {

            $this->saleItemService->flushAll();

            return response()->json([
                'message' => 'Items excluidos com sucesso',
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ]);
        }
    }

    private function validate(Request $request)
    {
        $request->validate([
            'qty' => 'required|min:1|max:100|integer',
        ]);
    }

}
