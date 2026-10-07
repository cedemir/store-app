<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private Product $product) {}

    public function index()
    {
        $products = $this->product->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create(Category $category)
    {
        $categories = $category->all(['id', 'name']);

        return view('products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['price']       = (float) str_replace(['.', ','], ['', '.'], $data['price']);

        $product = $this->product->create($data);

        $product->categories()->sync($data['categories']);

        return redirect()->route('products.edit', ['product' => $product->id]);
    }

    public function show($product)
    {
        return redirect()->route('products.edit', ['product' => $product]);
    }

    public function edit($product, Category $category)
    {
        $product = $this->product->findOrFail($product);
        $categories = $category->all(['id', 'name']);

        return view('products.edit', compact('product', 'categories'));
    }

    public function update($product, ProductRequest $request)
    {
        //Atualizando com mass assignment
        $data = $request->all();
        $data['price'] = (float) str_replace(['.', ','], ['', '.'], $data['price']);

        $product = $this->product->findOrFail($product);
        $product->update($data);

        $product->categories()->sync($data['categories']);

        return redirect()->route('products.edit', ['product' => $product->id]);
    }

    public function destroy($product)
    {
        $product = $this->product->findOrFail($product);
        $product->delete();

        return redirect()->route('products.index');
    }
}
