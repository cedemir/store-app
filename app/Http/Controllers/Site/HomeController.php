<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Product $product)
    {
        /**
         * Teste policy e gate define
         *  auth()->loginUsingId(13);
         *  dump(\Illuminate\Support\Facades\Gate::allows('exemplo'));
         *  dd(\Illuminate\Support\Facades\Gate::allows('update', Product::find(2)));
         */

        $products = $product->whereIsActive(true)->orderBy('id', 'DESC')->take(10)->get();

        return view('site.home', compact('products'));
    }

    public function single(Product $product)
    {
        $product->load('photos');

        return view('site.single', compact('product'));
    }
}
