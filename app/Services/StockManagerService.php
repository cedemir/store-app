<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class StockManagerService
{
    public function __construct(private Order $order)
    {
    }

    public function removeProductFromStock()
    {
        foreach ($this->order->items as $item) {
            Product::find($item->product_id)->decrement('in_stock', $item->quantity);
        }
    }

    public function addingProductInStock()
    {
        foreach ($this->order->items as $item) {
            Product::find($item->product_id)->increment('in_stock', $item->quantity);
        }
    }
}
