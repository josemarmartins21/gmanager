<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\products\contracts\ProductInterface;
use Illuminate\Support\Facades\Gate;

class ProductExcludedController extends Controller
{
    public function __construct(
        private ProductInterface $productService,
    )
    {}
    
    public function index()
    {
        try {

            Gate::allowIf(fn (User $user) => $user->can('visualizar productos apagados'));

            $products =  $this->productService->allTrashed();

            return view('products-recycle.index', compact('products'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            
            Gate::allowIf(fn (User $user) => $user->can('restaurar producto apagado'));

            $this->productService->restore($id);

            return back()->with('success', 'Producto restaurado com successo!');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function restoreAll()
    {
        try {
            
            Gate::allowIf(fn (User $user) => $user->can('restaurar productos apagados'));

            $this->productService->restoreAll();

            return back()->with('success', 'Productos restaurados com sucesso!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    public function destroy(string $id)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('apagar producto definitivamente'));
            $this->productService->permanentlyDelete($id);

            return back()->with('success', 'Producto eliminado definitivamente com successo!');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroyAll()
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('apagar todos os productos definitivamente'));
           
            $this->productService->cleanAll();

            return back()->with('success', 'Lixeira esvasiada com sucesso!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

}
