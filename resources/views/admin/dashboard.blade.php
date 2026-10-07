@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <x-admin.page-header title="Dashboard" subtitle="Visão geral da loja" />

    @php
        $cards = [
            ['label' => 'Produtos',   'value' => $stats['products'],   'extra' => $stats['active_products'] . ' ativos', 'route' => 'products.index',   'icon' => 'cube'],
            ['label' => 'Categorias', 'value' => $stats['categories'], 'extra' => null,                                'route' => 'categories.index', 'icon' => 'tag'],
            ['label' => 'Pedidos',    'value' => $stats['orders'],     'extra' => null,                                'route' => 'orders.index',     'icon' => 'bag'],
            ['label' => 'Clientes',   'value' => $stats['customers'],  'extra' => null,                                'route' => 'users.index',      'icon' => 'users'],
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        @foreach($cards as $card)
            <a href="{{ route($card['route']) }}" class="card p-5 flex items-center gap-4 hover:shadow-lg transition">
                <div class="p-3 rounded-full bg-brand-500/20 text-brand-300">
                    <x-admin.icon :name="$card['icon']" class="size-6" />
                </div>
                <div>
                    <p class="text-sm text-slate-300">{{ $card['label'] }}</p>
                    <p class="text-2xl font-bold">{{ $card['value'] }}</p>
                    @if($card['extra'])
                        <p class="text-xs text-slate-400">{{ $card['extra'] }}</p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="card p-5">
            <h2 class="font-semibold mb-4">Faturamento confirmado</h2>
            <p class="text-3xl font-bold text-emerald-400 mb-6">R$ {{ number_format($revenue, 2, ',', '.') }}</p>

            <h3 class="text-sm font-medium text-slate-300 mb-2">Pedidos por status</h3>
            <ul class="space-y-2">
                @foreach(\App\Enums\OrderStatusEnum::cases() as $status)
                    <li class="flex justify-between items-center text-sm">
                        <x-admin.badge :color="$status->color()">{{ $status->status() }}</x-admin.badge>
                        <a href="{{ route('orders.index', ['status' => $status->name]) }}" class="font-semibold hover:underline">
                            {{ $ordersByStatus[$status->name] ?? 0 }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="card p-5 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold">Últimos pedidos</h2>
                <a href="{{ route('orders.index') }}" class="text-sm text-brand-300 hover:underline">Ver todos</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-300 border-b">
                            <th class="py-2 pr-4">#</th>
                            <th class="py-2 pr-4">Cliente</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrders as $order)
                            <tr class="border-b last:border-0">
                                <td class="py-2 pr-4">
                                    <a href="{{ route('orders.edit', $order) }}" class="text-brand-300 hover:underline">{{ $order->id }}</a>
                                </td>
                                <td class="py-2 pr-4">{{ $order->customer?->name }}</td>
                                <td class="py-2 pr-4"><x-admin.badge :color="$order->status->color()">{{ $order->status->status() }}</x-admin.badge></td>
                                <td class="py-2 pr-4 text-right">R$ {{ number_format($order->totalOrder(), 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 text-center text-slate-300">Nenhum pedido ainda.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card p-5">
        <h2 class="font-semibold mb-4">Produtos com estoque baixo (≤ 5)</h2>
        @forelse($lowStockProducts as $product)
            <div class="flex justify-between items-center py-2 border-b last:border-0 text-sm">
                <a href="{{ route('products.edit', $product) }}" class="hover:underline">{{ $product->name }}</a>
                <x-admin.badge :color="$product->in_stock <= 0 ? 'red' : 'yellow'">{{ $product->in_stock }} em estoque</x-admin.badge>
            </div>
        @empty
            <p class="text-sm text-slate-300">Nenhum produto com estoque baixo.</p>
        @endforelse
    </div>
@endsection
