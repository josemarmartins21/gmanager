<?php

namespace App\Models;

use App\Observers\SaleObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SaleObserver::class)]
#[Fillable(['total', 'total_payed', 'status', 'note', 'user_id'])]
class Sale extends Model
{
    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory;

    #[Scope]
    protected function payedThisMonth(Builder $query, bool $status): void
    {
        $query->where('status', $status)->whereMonth('created_at', now()->month);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
