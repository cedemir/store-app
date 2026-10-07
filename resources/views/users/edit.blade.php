@extends('layouts.app')

@section('content')
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
        @csrf
        @method('PUT')

        @include('users._form', ['user' => $user])

        <button class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Atualizar
            Usuário</button>
    </form>

    @unless($user->is(auth()->user()))
        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post"
            onsubmit="return confirm('Deseja realmente remover este usuário?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-700 border border-red-900 rounded text-white font-thin mt-8">Remover
                Usuário</button>
        </form>
    @endunless
@endsection
