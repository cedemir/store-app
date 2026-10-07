<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'products'        => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'categories'      => Category::count(),
            'orders'          => Order::count(),
            'customers'       => User::where('role', 'ROLE_CUSTOMER')->count(),
        ];

        $ordersByStatus = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $revenue = Order::with('items.product')
            ->where('status', OrderStatusEnum::PAYMENT_CONFIRMED->name)
            ->get()
            ->sum(fn(Order $order) => $order->totalOrder());

        $latestOrders = Order::with('customer', 'items.product')->latest('id')->take(5)->get();

        $lowStockProducts = Product::where('in_stock', '<=', 5)->orderBy('in_stock')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'ordersByStatus', 'revenue', 'latestOrders', 'lowStockProducts'));
    }
}
