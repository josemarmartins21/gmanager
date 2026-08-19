<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\products\contracts\ProductInterface;
class ProductExcludedController extends Controller
{
    public function __construct(
        private ProductInterface $productService,
    )
    {}
    
    public function index()
    {
        try {
        
            return response()->json([
                'products' => $this->productService->allTrashed(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function restore(string $id)
    {
        try {
            
            $this->productService->restore($id);

            return response()->json([
                'message' => 'Producto restaurado com successo!',
                'data' => Product::find($id),
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function restoreAll()
    {
        try {
            
            $this->productService->restoreAll();

            return response()->json([
                'message' => 'Productos restaurados com successo!',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    
    public function destroy(string $id)
    {
        try {
            $this->productService->permanentlyDelete($id);

            return response()->json([
                'message' => 'Producto excluido definitivamente com sucesso!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroyAll()
    {
        try {
           
            $this->productService->cleanAll();

            return response()->json([
                'message' => 'Lixeira esvasiada com sucesso!',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

}
