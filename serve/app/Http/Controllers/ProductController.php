<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Product;
use App\Models\User;
use App\Services\products\contracts\ProductInterface;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{

    public function __construct(
        private ProductInterface $productService,
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            Gate::allowIf(fn (User $user) => $user->can('products:read') || $user->hasRole('admin'));
            $products = $this->productService->all();

            return view('products.index', compact('products'));

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
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
    public function store(ProductRequest $request)
    {
        try {

            $validated = $request->validated();

            $product = $this->productService->save($validated);

            return response()->json([
                'data' => $product,
            ], 201);
            
        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {

            return $this->productService->get($product->id);

        } catch (\Exception $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {
            $validated = $request->validated();

            $this->productService->update($product, $validated);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            
            $this->productService->delete($product);

            return response()->json([
                'message' => 'Producto excluido com sucesso!',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
