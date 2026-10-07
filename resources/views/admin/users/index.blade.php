@extends('layouts.admin')

@section('title', 'Usuários')

@section('content')
    <x-admin.page-header title="Usuários" :subtitle="$users->total() . ' registro(s)'">
        <a href="{{ route('users.create') }}"
            class="btn btn-primary">
            <x-admin.icon name="plus" class="size-4" /> Novo Usuário
        </a>
    </x-admin.page-header>

    <x-admin.search placeholder="Buscar por nome ou e-mail...">
        <select name="status" class="form-input w-auto">
            <option value="">Todos os perfis</option>
            <option value="ROLE_ADMIN" @selected(request('status') === 'ROLE_ADMIN')>Administradores</option>
            <option value="ROLE_CUSTOMER" @selected(request('status') === 'ROLE_CUSTOMER')>Clientes</option>
        </select>
    </x-admin.search>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-navy-950/40 text-left text-xs uppercase tracking-wide text-slate-300">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">E-mail</th>
                    <th class="px-4 py-3">Perfil</th>
                    <th class="px-4 py-3">Pedidos</th>
                    <th class="px-4 py-3">Criado em</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-t border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3">{{ $user->id }}</td>
                        <td class="px-4 py-3 font-medium">
                            {{ $user->name }}
                            @if($user->is(auth()->user()))
                                <span class="text-xs text-slate-400">(você)</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-300">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->role === 'ROLE_ADMIN')
                                <x-admin.badge color="purple">Administrador</x-admin.badge>
                            @else
                                <x-admin.badge>Cliente</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($user->orders_count)
                                <a href="{{ route('orders.index', ['q' => $user->name]) }}" class="text-brand-300 hover:underline">{{ $user->orders_count }}</a>
                            @else
                                0
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $user->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('users.edit', $user) }}"
                                    class="btn btn-secondary btn-sm">
                                    <x-admin.icon name="pencil" class="size-4" /> Editar
                                </a>
                                @unless($user->is(auth()->user()))
                                    <x-admin.delete-button :action="route('users.destroy', $user)"
                                        confirm="Remover o usuário? Os pedidos dele também serão removidos." />
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-slate-300">Nada encontrado!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection
