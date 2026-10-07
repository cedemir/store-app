<?php

namespace App\Listeners;

use App\Events\UserCancelledOrderEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\StockManagerService;

class PutProductsBackOnStockListener
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
    public function handle(UserCancelledOrderEvent $event): void
    {
        (new StockManagerService($event->order))->addingProductInStock();
    }
}
