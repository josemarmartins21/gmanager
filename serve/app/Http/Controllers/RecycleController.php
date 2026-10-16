<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockMovement;
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
            'stock_movement_trashed_qty' => StockMovement::trashedQty(),
        ]);
    }
}
