<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sales\SaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Services\Sales\Contracts\CartSessionInterface;
use App\Services\Sales\Contracts\SaleInterface;
use Illuminate\Support\Facades\Gate;

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
            Gate::allowIf(fn (User $user) => $user->can('visualizar vendas'));

            $sales = $this->saleService->all();

            return view('sales.index', compact('sales'));

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::allowIf(fn (User $user) => $user->can('criar venda'));

        $products = Product::all('name', 'id', 'price');

        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('criar venda'));

            $saleDetails = $request->only(['note', 'total_payed']);
            $saleItems = $this->cartService->getAllItems();
            
            $this->saleService->save($saleItems, $saleDetails);

            $this->cartService->flushAll();

            return redirect()->route('sales.index')->with('success', 'Venda realizada com sucesso!');

        } catch (\Exception $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('excluir venda'));
            $this->saleService->delete($sale);

            return back()->with('success', 'Venda excluida com sucesso!');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
