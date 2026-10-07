<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class RecycleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('recycle', [
            'sale_trashed_qty' => Sale::trashedQty(),
            'product_trashed_qty' => Product::trashedQty(),
        ]);
    }
}
