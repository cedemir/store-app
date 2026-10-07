@extends('layouts.admin')

@section('title', 'Novo Produto')

@section('content')
    <x-admin.page-header title="Novo Produto" :back="route('products.index')" />

    <form action="{{ route('products.store') }}" method="post">
        @csrf
        @include('admin.products._form', ['submit' => 'Criar Produto'])
    </form>
@endsection
