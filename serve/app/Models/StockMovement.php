<?php

namespace App\Models;

use App\Observers\StockMovementObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(StockMovementObserver::class)]
#[Fillable(['box_price', 'note', 'total_units', 'product_id',
'units_per_box', 'product_name', 'box_qty', 'type', 'user_id'])]
class StockMovement extends Model
{
    /** @use HasFactory<\Database\Factories\StockMovementFactory> */
    use HasFactory, SoftDeletes;

    #[Scope]
    protected function trashedQty(Builder $query): void
    {
        $query->onlyTrashed();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
