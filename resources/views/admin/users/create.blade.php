@extends('layouts.admin')

@section('title', 'Novo Usuário')

@section('content')
    <x-admin.page-header title="Novo Usuário" :back="route('users.index')" />

    <form action="{{ route('users.store') }}" method="post">
        @csrf
        @include('admin.users._form', ['submit' => 'Criar Usuário'])
    </form>
@endsection
