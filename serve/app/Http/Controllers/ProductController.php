<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\products\contracts\ProductInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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

            Gate::allowIf(fn (User $user) => $user->can('products:read'));

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
        Gate::allowIf(fn (User $user) => $user->can('products:create'));

        $categories = Category::all('name', 'id');

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('products:create'));

            $validated = $request->validated();

            $product = $this->productService->save($validated);

            return redirect()->route('products.index')->with('success', Str::ucwords($product->name) . '  registada(o) com sucesso!');
            
        } catch (\Exception $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('products:read'));

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
        Gate::allowIf(fn (User $user) => $user->can('products:update'));

        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('products:update'));

            $validated = $request->validated();

            $this->productService->update($product, $validated);

            return redirect()->back()->with('success', Str::ucwords($product->name) . ' actualizada(o) com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('products:delete'));

            $this->productService->delete($product);

            return redirect()->route('products.index')->with('success', Str::ucwords($product->name) . ' eliminada(o) com sucesso!');

        } catch (\Exception $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }
}
