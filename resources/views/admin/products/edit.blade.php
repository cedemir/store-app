@extends('layouts.admin')

@section('title', 'Editar Produto')

@section('content')
    <x-admin.page-header :title="'Editar: ' . $product->name" :back="route('products.index')">
        <a href="{{ route('photos.index', $product) }}"
            class="btn btn-secondary">
            <x-admin.icon name="photo" class="size-4" /> Fotos ({{ $product->photos->count() }})
        </a>
        <a href="{{ route('site.single', $product->slug) }}" target="_blank"
            class="btn btn-secondary">
            <x-admin.icon name="store" class="size-4" /> Ver na loja
        </a>
        <x-admin.delete-button :action="route('products.destroy', $product)" label="Remover" confirm="Remover o produto e suas fotos?" />
    </x-admin.page-header>

    <form action="{{ route('products.update', $product) }}" method="post">
        @csrf
        @method('PUT')
        @include('admin.products._form', ['submit' => 'Salvar Alterações'])
    </form>
@endsection
