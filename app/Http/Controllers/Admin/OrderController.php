<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Events\UserCancelledOrderEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private Order $order) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = $this->order
            ->with('customer', 'items.product')
            ->when($request->q, fn($query, $q) => $query->where(
                fn($query) => $query->where('code', 'like', "%{$q}%")
                    ->orWhereHas('customer', fn($query) => $query->where('name', 'like', "%{$q}%"))
            ))
            ->when($request->status, fn($query, $status) => $query->where('status', $status))
            ->orderBy('id', 'DESC')
            ->paginate(15)
            ->withQueryString();

        $statuses = OrderStatusEnum::cases();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return redirect()->route('orders.edit', ['order' => $order->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load('customer', 'items.product');
        $statuses = OrderStatusEnum::cases();

        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        // Pedidos cancelados já devolveram os produtos ao estoque
        if ($order->status === OrderStatusEnum::CUSTOMER_CANCELLED) {
            return redirect()->back()->with('warning', 'Pedidos cancelados não podem ter o status alterado.');
        }

        $newStatus = $request->validated('status');

        $order->update(['status' => $newStatus]);

        if ($newStatus === OrderStatusEnum::CUSTOMER_CANCELLED->name) {
            event(new UserCancelledOrderEvent($order));
        }

        return redirect()->route('orders.edit', ['order' => $order->id])
            ->with('success', 'Pedido atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Devolve os produtos ao estoque caso o pedido ainda não tenha sido cancelado
        if ($order->status !== OrderStatusEnum::CUSTOMER_CANCELLED) {
            event(new UserCancelledOrderEvent($order));
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pedido removido com sucesso!');
    }
}
