<?php

namespace App\Http\Controllers;

use App\Factories\RecycleFactory;
use App\Models\User;
use App\Strategies\Recycles\Contracts\RecycleInterface;
use Illuminate\Support\Facades\Gate;

class SaleExcludedController extends Controller
{
    private RecycleInterface $saleRecycle;

    public function __construct()
    {
        $this->saleRecycle = RecycleFactory::create('sales');
    }
    
    public function index()
    {
        try {

            Gate::allowIf(fn (User $user) => $user->can('visualizar vendas apagadas'));

            $sales =  $this->saleRecycle->allTrashed();

            return view('recycles.sales-recycle', compact('sales'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            
            Gate::allowIf(fn (User $user) => $user->can('restaurar vendas apagadas'));

            $this->saleRecycle->restore($id);

            return back()->with('success', 'Venda restaurada com successo!');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function restoreAll()
    {
        try {
            
            Gate::allowIf(fn (User $user) => $user->can('restaurar vendas apagadas'));

            $this->saleRecycle->restoreAll();

            return back()->with('success', 'Vendas restauradas com successo!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    public function destroy(string $id)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('apagar vendas definitivamente'));
            $this->saleRecycle->permanentlyDelete($id);

            return back()->with('success', 'Venda eliminada definitivamente com successo!');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroyAll()
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('apagar todas as vendas definitivamente'));
           
            $this->saleRecycle->cleanAll();

            return back()->with('success', 'Lixeira de vendas esvaziada com sucesso!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

}
