<?php

namespace App\Http\Controllers;

use App\Factories\RecycleFactory;
use App\Models\User;
use App\Strategies\Recycles\Contracts\RecycleInterface;
use App\Trait\PermissionTrait;
use Illuminate\Support\Facades\Gate;

class ProductExcludedController extends Controller
{
    use PermissionTrait;
    
    private RecycleInterface $productRecycle;

    public function __construct()
    {
        $this->productRecycle = RecycleFactory::create('products');
    }
    
    public function index()
    {
        try {

            $this->hasAuthorization('visualizar productos apagados');

            $products =  $this->productRecycle->allTrashed();

            return view('recycles.products-recycle', compact('products'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function restore(string $id)
    {
        try {
            
            $this->hasAuthorization('restaurar producto apagado');

            $this->productRecycle->restore($id);

            return back()->with('success', 'Producto restaurado com successo!');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function restoreAll()
    {
        try {
            
            $this->hasAuthorization('restaurar productos apagados');

            $this-> productRecycle->restoreAll();

            return back()->with('success', 'Productos restaurados com sucesso!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    
    public function destroy(string $id)
    {
        try {
            $this->hasAuthorization('apagar producto definitivamente');
            $this->productRecycle->permanentlyDelete($id);

            return back()->with('success', 'Producto eliminado definitivamente com successo!');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroyAll()
    {
        try {
            $this->hasAuthorization('apagar todos os productos definitivamente');
           
            $this->productRecycle->cleanAll();

            return back()->with('success', 'Lixeira esvaziada com sucesso!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

}
