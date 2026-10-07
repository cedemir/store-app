<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function index()
    {
        $cartItems = $this->cartService->all();
        return view('site.cart', compact('cartItems'));
    }

    public function add(CartRequest $request, Product $product)
    {
        $item = $request->validated('cart');

        $product = $product->whereSlug($item['product'])->firstOrFail();

        $this->cartService->add([
            'id'       => $product->id,
            'quantity' => $item['quantity'],
            'slug'     => $product->slug,
            'name'     => $product->name,
            'photo'    => $product->thumb,
            'price'    => $product->price
        ]);

        session()->flash('success', 'Produto Adicionado com Sucesso!');
        return redirect()->back();
    }

    public function remove(string $item)
    {
        if(!$this->cartService->has($item, column: 'slug')) {
            return redirect()->route('site.index');
        }

        $this->cartService->remove($item);

        return redirect()->route('site.cart.index');
    }

    public function cancel()
    {
        $this->cartService->clear();

        return redirect()->route('site.home');
    }
}
