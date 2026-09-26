<?php 

namespace App\Services\Support;


use App\Models\Sale;


class DashboardKpis
{
    public static function financialSummary(): array
    {
        $sales = Sale::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('
                COALESCE(SUM(total), 0) as revenue,
                COALESCE(SUM(total_payed), 0) as received
            ')
            ->first();

        $revenue = (float) $sales->revenue;
        $received = (float) $sales->received;

        return [
            'revenue' => $revenue,
            'received' => $received,
            'pending' => max(0, $revenue - $received),
        ];
    }
}