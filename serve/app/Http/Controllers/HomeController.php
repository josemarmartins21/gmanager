<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $financial = self::financialSummary();
        $topProducts = self::topProducts();

        return view('welcome', compact('financial', 'topProducts'));
    }

    private static function financialSummary(): array
    {
       $sales = Sale::query()
        ->where('total', '<', 25000)
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->selectRaw('
            COALESCE(SUM(total), 0) AS revenue,

            COALESCE(SUM(total_payed), 0) AS received,

            COALESCE(SUM(CASE
                WHEN status = false
                THEN total - total_payed
                ELSE 0
            END), 0) AS pending
        ')
        ->first();

        return [
            'revenue' => (float) $sales->revenue,
            'received' => (float) $sales->received,
            'pending' => max(0, (float) $sales->pending),
        ];
    }

    private static function topProducts(int $limit = 3): array
    {
        $products = Product::query()
            ->select([
                'products.id',
                'products.name',
                DB::raw('SUM(sale_items.qty) as total_sold')
            ])
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();

        $grandTotal = $products->sum('total_sold');

        return $products->map(function ($product) use ($grandTotal) {

            $percentage = $grandTotal > 0
                ? ($product->total_sold / $grandTotal) * 100
                : 0;

            return [
                'name' => $product->name,
                'total_sold' => $product->total_sold,
                'percentage' => round($percentage, 1),
                'bar_width' => round($percentage),
            ];

        })->toArray();
    }
}
