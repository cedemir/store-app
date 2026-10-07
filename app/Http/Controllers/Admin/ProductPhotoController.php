<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductPhotoRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function index(Product $product)
    {
        $product->load('photos');

        return view('admin.products.photos', compact('product'));
    }

    public function store(Product $product, ProductPhotoRequest $request)
    {
        $photosReference = [];

        foreach ($request->validated('photos') as $photo) {
            $photosReference[] = ['photo' => $photo->store('product/photos', 'public')];
        }

        $product->photos()->createMany($photosReference);

        return redirect()->route('photos.index', ['product' => $product->id])
            ->with('success', 'Fotos enviadas com sucesso!');
    }

    public function destroy(Product $product, string $photo)
    {
        $photo = $product->photos()->findOrFail($photo);

        Storage::disk('public')->delete($photo->photo);

        $photo->delete();

        return redirect()->route('photos.index', ['product' => $product->id])
            ->with('success', 'Foto removida com sucesso!');
    }
}
