@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <x-admin.page-header title="Pedidos" :subtitle="$orders->total() . ' registro(s)'" />

    <x-admin.search placeholder="Buscar por código ou cliente...">
        <select name="status" class="form-input w-auto">
            <option value="">Todos os status</option>
            @foreach($statuses as $status)
                <option value="{{ $status->name }}" @selected(request('status') === $status->name)>{{ $status->status() }}</option>
            @endforeach
        </select>
    </x-admin.search>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-navy-950/40 text-left text-xs uppercase tracking-wide text-slate-300">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Código</th>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Itens</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3">Data</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-t border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3">{{ $order->id }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-slate-300">{{ str($order->code)->limit(13) }}</td>
                        <td class="px-4 py-3">{{ $order->customer?->name }}</td>
                        <td class="px-4 py-3"><x-admin.badge :color="$order->status->color()">{{ $order->status->status() }}</x-admin.badge></td>
                        <td class="px-4 py-3 text-right">{{ $order->items->sum('quantity') }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">R$ {{ number_format($order->totalOrder(), 2, ',', '.') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('orders.edit', $order) }}"
                                    class="btn btn-secondary btn-sm">
                                    <x-admin.icon name="pencil" class="size-4" /> Detalhes
                                </a>
                                <x-admin.delete-button :action="route('orders.destroy', $order)"
                                    confirm="Remover o pedido? Se não estiver cancelado, os produtos voltam ao estoque." />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-6 text-center text-slate-300">Nada encontrado!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endsection
