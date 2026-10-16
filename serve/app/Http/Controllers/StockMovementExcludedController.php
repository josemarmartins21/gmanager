<?php

namespace App\Http\Controllers;

use App\Factories\RecycleFactory;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Strategies\Recycles\Contracts\RecycleInterface;
use Illuminate\Support\Facades\Gate;

class StockMovementExcludedController extends Controller
{
        private RecycleInterface $stockMovementRecycle;

    public function __construct()
    {
        $this->stockMovementRecycle = RecycleFactory::create('stock-movement');
    }
    
    public function index()
    {
        try {

            Gate::allowIf(fn (User $user) => $user->can('visualizar movimentações de estoque apagadas'));

            $stockMovements =  $this->stockMovementRecycle->allTrashed();

            return view('recycles.stock-movement-recycle', compact('stockMovements'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            
            Gate::allowIf(fn (User $user) => $user->can('restaurar movimentação de estoque apagada'));

            $this->stockMovementRecycle->restore($id);

            return back()->with('success', 'Movimentação de estoque restaurada com successo!');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function restoreAll()
    {
        try {
            
            Gate::allowIf(fn (User $user) => $user->can('restaurar movimentações de estoque apagadas'));

            $this->stockMovementRecycle->restoreAll();

            return back()->with('success', 'Movimentações de estoque restauradas com successo!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    public function destroy(string $id)
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('apagar movimentação de estoque definitivamente'));
            $this->stockMovementRecycle->permanentlyDelete($id);

            return back()->with('success', 'Movimentação de estoque eliminada definitivamente com successo!');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroyAll()
    {
        try {
            Gate::allowIf(fn (User $user) => $user->can('apagar todas as movimentações de estoque definitivamente'));
           
            $this->stockMovementRecycle->cleanAll();

            return back()->with('success', 'Lixeira de movimentações de estoque esvaziada com sucesso!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
