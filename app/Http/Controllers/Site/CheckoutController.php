<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use App\Services\Payments\PaymentInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private Order $modelOrder)
    {
    }

    public function index()
    {
        return view('site.checkout');
    }

    public function process(PaymentInterface $payment, CartService $cart)
    {
        if(!$cart->count()) {
            session()->flash('warning', 'Sem Itens para Processar Checkout!');
            return redirect()->route('site.home');
        }

        $customer = auth()->user();

        $order = $this->modelOrder->create([
            'code' => Str::uuid(),
            'user_id' => $customer->id
        ]);

        $saveOrderItems = [];
        foreach($cart->all() as $item) {
            $saveOrderItems[] = [
                'quantity' => $item['quantity'],
                'product_id' => $item['id'],
            ];
        }
        $order->items()->createMany($saveOrderItems);

        $gatewayCode = $payment->doPayment([
            'our_code' => $order->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'cardToken' => 'XYZ',
            'paymentMethod' => 'CREDIT_CARD'
        ])['gateway_code'];


        $order->update(['gateway_code' => $gatewayCode]);

        event(new \App\Events\UserOrderedProductsEvent($order));

        session()->forget(CartService::SESSION_KEY);

        return redirect()->route('site.checkout.thanks', $order);
    }

    public function thanks(Order $order)
    {
        return view('site.thanks', compact('order'));
    }
}
