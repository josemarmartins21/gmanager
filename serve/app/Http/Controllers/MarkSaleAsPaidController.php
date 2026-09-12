<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class MarkSaleAsPaidController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Sale $sale, Request $request)
    {
        try {

            $this->changeStatus($sale);

            return back();

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function changeStatus(Sale $sale): void
    {
        try {

            $sale->status = $sale->status ? 0 : 1;

            $sale->total_payed = $sale->fresh()->status ? 0 : $sale->total;
            $sale->save();

        } catch (\Throwable) {
            throw new \Exception("Erro ao alterar o status da venda");
        }
    }
}
