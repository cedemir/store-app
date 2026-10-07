@extends('layouts.app')

@section('content')
    <form action="{{ route('users.store') }}" method="post">
        @csrf

        @include('users._form')

        <button class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Criar Usuário</button>
    </form>
@endsection
