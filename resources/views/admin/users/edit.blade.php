@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
    <x-admin.page-header :title="'Editar: ' . $user->name" :back="route('users.index')">
        @unless($user->is(auth()->user()))
            <x-admin.delete-button :action="route('users.destroy', $user)" label="Remover Usuário"
                confirm="Remover o usuário? Os pedidos dele também serão removidos." />
        @endunless
    </x-admin.page-header>

    <form action="{{ route('users.update', $user) }}" method="post">
        @csrf
        @method('PUT')
        @include('admin.users._form', ['submit' => 'Salvar Alterações'])
    </form>
@endsection
