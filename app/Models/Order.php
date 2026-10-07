<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'code', 'status', 'gateway_code'
    ];


    protected function casts(): array
    {
        return [
            'status' => OrderStatusEnum::class,
        ];
    }

    public function customer():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function totalOrder()
    {
        $total = $this->items->reduce(function(?int $total, $item) {
            return $total += ($item->quantity * $item->product->price);
        });

        return $total;
    }
}
