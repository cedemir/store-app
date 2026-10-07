@extends('layouts.app')

@section('content')
    <div class="w-full mb-10 flex justify-between">
        <h2 class="font-bold text-xl">Usuários</h2>
        <a href="{{ route('users.create') }}"
            class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Criar Usuário</a>
    </div>
    <div class="w-full p-5">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-600">
                    <th class="px-4 py-2 text-xl text-left">#</th>
                    <th class="px-4 py-2 text-xl text-left">Nome</th>
                    <th class="px-4 py-2 text-xl text-left">E-mail</th>
                    <th class="px-4 py-2 text-xl text-left">Perfil</th>
                    <th class="px-4 py-2 text-xl text-left">Criado em</th>
                    <th class="px-4 py-2 text-xl text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-2 text-normal text-left">{{ $user->id }}</td>
                        <td class="px-4 py-2 text-normal text-left">{{ $user->name }}</td>
                        <td class="px-4 py-2 text-normal text-left">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-normal text-left">
                            {{ $user->role === 'ROLE_ADMIN' ? 'Administrador' : 'Cliente' }}
                        </td>
                        <td class="px-4 py-2 text-normal text-left">{{ $user->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="w-[15%] px-4 py-2 text-normal text-left">
                            <div class="flex justify-around gap-x-2">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                    class="px-4 py-2 bg-blue-700 border border-blue-900 rounded text-white font-thin">
                                    Editar
                                </a>
                                @unless($user->is(auth()->user()))
                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post"
                                        onsubmit="return confirm('Deseja realmente remover este usuário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-700 border border-red-900 rounded text-white font-thin">Remover</button>
                                    </form>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nada encontrado!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="w-full mt-10">
        {{ $users->links() }}
    </div>
@endsection
