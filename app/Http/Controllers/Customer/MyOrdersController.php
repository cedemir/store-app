<?php

namespace App\Http\Controllers\Customer;

use App\Events\UserCancelledOrderEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class MyOrdersController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->orderBy('id', 'DESC')->paginate(5);

        return view('customer.my-orders', compact('orders'));
    }

    public function cancelOrder(Order $order)
    {
        if($order->status->name === 'CUSTOMER_CANCELLED') return redirect()->back();

        $order->update(['status' => 'CUSTOMER_CANCELLED']);

        event(new UserCancelledOrderEvent($order));

        return redirect()->route('customers.my-orders');
    }
}
