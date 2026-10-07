@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')
    <x-admin.page-header :title="'Editar: ' . $category->name" :back="route('categories.index')">
        <x-admin.delete-button :action="route('categories.destroy', $category)" label="Remover Categoria"
            confirm="Remover a categoria? Os produtos não serão removidos." />
    </x-admin.page-header>

    <form action="{{ route('categories.update', $category) }}" method="post">
        @csrf
        @method('PUT')
        @include('admin.categories._form', ['submit' => 'Salvar Alterações'])
    </form>
@endsection
