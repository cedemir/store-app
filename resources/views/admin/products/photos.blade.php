@extends('layouts.admin')

@section('title', 'Fotos do Produto')

@section('content')
    <x-admin.page-header :title="'Fotos: ' . $product->name" :back="route('products.edit', $product)"
        subtitle="A primeira foto é usada como capa na loja." />

    <form action="{{ route('photos.store', $product) }}" method="post" enctype="multipart/form-data"
        class="card p-6 mb-6">
        @csrf

        <label class="block mb-2 text-sm font-medium @if($errors->has('photos') || $errors->has('photos.*')) text-red-400 @else text-white @endif">
            Selecione as fotos do produto
        </label>
        <input type="file" name="photos[]" accept="image/*" multiple required
            class="form-input file:mr-4 file:px-3 file:py-1 file:rounded-lg file:border-0 file:bg-brand-500/20 file:text-brand-200">

        @error('photos')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
        @error('photos.*')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror

        <button class="mt-4 btn btn-primary">Enviar Fotos</button>
    </form>

    <div class="card p-6">
        @if($product->photos->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($product->photos as $photo)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $photo->photo) }}" alt="" class="w-full aspect-square object-cover rounded-xl ring-1 ring-white/10">
                        <div class="absolute top-2 right-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition">
                            <x-admin.delete-button :action="route('photos.destroy', ['product' => $product, 'photo' => $photo->id])"
                                label="" confirm="Deseja mesmo remover a foto?"  />
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-slate-300">Sem fotos para este produto!</p>
        @endif
    </div>
@endsection
