<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(private Product $product) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->product
            ->with('photos', 'categories')
            ->when($request->q, fn($query, $q) => $query->where('name', 'like', "%{$q}%"))
            ->when($request->filled('status'), fn($query) => $query->where('is_active', $request->status === 'active'))
            ->orderBy('id', 'DESC')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        $product = $this->product->create($data);
        $product->categories()->sync($data['categories']);

        return redirect()->route('products.edit', ['product' => $product->id])
            ->with('success', 'Produto criado com sucesso! Agora você pode adicionar fotos.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return redirect()->route('products.edit', ['product' => $product->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('categories', 'photos');
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);
        $product->categories()->sync($data['categories']);

        return redirect()->route('products.edit', ['product' => $product->id])
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Itens de pedido referenciam o produto sem cascade, então preservamos o histórico
        if (OrderItem::where('product_id', $product->id)->exists()) {
            return redirect()->back()
                ->with('error', 'Este produto possui pedidos e não pode ser removido. Desative-o em vez disso.');
        }

        $disk = Storage::disk('public');
        foreach ($product->photos as $photo) {
            $disk->delete($photo->photo);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto removido com sucesso!');
    }
}
