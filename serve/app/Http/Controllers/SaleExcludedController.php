<?php

namespace App\Http\Controllers;

use App\Factories\RecycleFactory;
use App\Models\User;
use App\Strategies\Recycles\Contracts\RecycleInterface;
use App\Trait\PermissionTrait;
use Illuminate\Support\Facades\Gate;

class SaleExcludedController extends Controller
{
    use PermissionTrait;

    private RecycleInterface $saleRecycle;

    public function __construct()
    {
        $this->saleRecycle = RecycleFactory::create('sales');
    }
    
    public function index()
    {
        try {

            $this->hasAuthorization('visualizar vendas apagadas');

            $sales =  $this->saleRecycle->allTrashed();

            return view('recycles.sales-recycle', compact('sales'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            
            $this->hasAuthorization('restaurar venda apagada');

            $this->saleRecycle->restore($id);

            return back()->with('success', 'Venda restaurada com successo!');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function restoreAll()
    {
        try {
            
            $this->hasAuthorization('restaurar vendas apagadas');

            $this->saleRecycle->restoreAll();

            return back()->with('success', 'Vendas restauradas com successo!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    public function destroy(string $id)
    {
        try {
            $this->hasAuthorization('apagar venda definitivamente');
            $this->saleRecycle->permanentlyDelete($id);

            return back()->with('success', 'Venda eliminada definitivamente com successo!');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroyAll()
    {
        try {
            $this->hasAuthorization('apagar todas as vendas definitivamente');
           
            $this->saleRecycle->cleanAll();

            return back()->with('success', 'Lixeira de vendas esvaziada com sucesso!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

}
