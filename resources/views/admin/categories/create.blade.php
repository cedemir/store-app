@extends('layouts.admin')

@section('title', 'Nova Categoria')

@section('content')
    <x-admin.page-header title="Nova Categoria" :back="route('categories.index')" />

    <form action="{{ route('categories.store') }}" method="post">
        @csrf
        @include('admin.categories._form', ['submit' => 'Criar Categoria'])
    </form>
@endsection
