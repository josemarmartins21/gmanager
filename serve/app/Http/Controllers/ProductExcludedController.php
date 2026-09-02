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

            $products =  $this->productService->allTrashed();

            return view('products-recycle.index', compact('products'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            
            $this->productService->restore($id);

            return back()->with('success', 'Producto restaurado com successo!');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
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

            return back()->with('success', 'Producto eliminado definitivamente com successo!');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
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
