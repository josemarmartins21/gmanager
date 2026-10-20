<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Sales\Contracts\CartSessionInterface;
use App\Trait\PermissionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SaleItemController extends Controller
{
    use PermissionTrait;

    public function __construct(
        private CartSessionInterface $saleItemService,
    )
    {}

    public function store(Request $request)
    {
        try {

            $this->hasAuthorization('criar venda');

            $this->validate($request);
        
            $this->saleItemService->add($request->product_id, $request->qty);

            return back();

        } catch (\Exception $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {

            $this->isAdmin();

            $request->validate([
                'id' => 'required|numeric|integer|exists:products,id',
            ]);

            $this->saleItemService->removeItem($request->id);

            return back()->with('success', 'Item removido com sucesso');

        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function removeAll()
    {
        try {
            $this->hasAuthorization('limpar carrinho');

            $this->saleItemService->flushAll();

            return back()->withInput()->with('success', 'Carrinho limpo com sucesso');

        } catch (\Exception $th) {
            return back()->withInput()->with('error', $th->getMessage());
        }
    }

    private function validate(Request $request)
    {
        $request->validate([
            'qty' => 'required|min:1|max:100|integer',
            'product_id' => 'required|numeric|integer|exists:products,id',
        ], [], [
            'qty' => 'quantidade',
            'product_id' => 'produto',
        ]);
    }

}
