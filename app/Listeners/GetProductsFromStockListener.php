<?php

namespace App\Listeners;

use App\Events\UserOrderedProductsEvent;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\StockManagerService;

class GetProductsFromStockListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserOrderedProductsEvent $event): void
    {
        (new StockManagerService($event->order))->removeProductFromStock();
    }
}
