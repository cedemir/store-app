@extends('layouts.admin')

@section('title', 'Pedido #' . $order->id)

@section('content')
    @php($cancelled = $order->status === \App\Enums\OrderStatusEnum::CUSTOMER_CANCELLED)

    <x-admin.page-header :title="'Pedido #' . $order->id" :subtitle="$order->code" :back="route('orders.index')">
        <x-admin.delete-button :action="route('orders.destroy', $order)" label="Remover Pedido"
            confirm="Remover o pedido? Se não estiver cancelado, os produtos voltam ao estoque." />
    </x-admin.page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="card overflow-x-auto lg:col-span-2">
            <table class="w-full text-sm">
                <thead class="bg-navy-950/40 text-left text-xs uppercase tracking-wide text-slate-300">
                    <tr>
                        <th class="px-4 py-3">Produto</th>
                        <th class="px-4 py-3 text-right">Preço</th>
                        <th class="px-4 py-3 text-right">Qtd.</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="border-t">
                            <td class="px-4 py-3">
                                @if($item->product)
                                    <a href="{{ route('products.edit', $item->product) }}" class="hover:underline">{{ $item->product->name }}</a>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">R$ {{ number_format($item->product?->price, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right">R$ {{ number_format($item->quantity * $item->product?->price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t bg-navy-800 font-semibold">
                        <td colspan="3" class="px-4 py-3 text-right">Total</td>
                        <td class="px-4 py-3 text-right">R$ {{ number_format($order->totalOrder(), 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="space-y-6">
            <div class="card p-6 text-sm space-y-2">
                <h2 class="font-semibold text-base mb-2">Cliente</h2>
                @if($order->customer)
                    <p><a href="{{ route('users.edit', $order->customer) }}" class="text-brand-300 hover:underline">{{ $order->customer->name }}</a></p>
                    <p class="text-slate-300">{{ $order->customer->email }}</p>
                @endif
                <p class="pt-2"><span class="text-slate-300">Criado em:</span> {{ $order->created_at?->format('d/m/Y H:i') }}</p>
                @if($order->gateway_code)
                    <p><span class="text-slate-300">Código no gateway:</span> <span class="font-mono text-xs">{{ $order->gateway_code }}</span></p>
                @endif
            </div>

            <form action="{{ route('orders.update', $order) }}" method="post" class="card p-6">
                @csrf
                @method('PUT')

                <x-admin.select name="status" label="Status do pedido" :disabled="$cancelled"
                    :options="collect($statuses)->mapWithKeys(fn($status) => [$status->name => $status->status()])->all()"
                    :value="$order->status->name" />

                @if($cancelled)
                    <p class="text-sm text-slate-300">Pedidos cancelados não podem mudar de status (o estoque já foi devolvido).</p>
                @else
                    <p class="text-xs text-slate-300 mb-4">Ao cancelar, os produtos voltam automaticamente ao estoque.</p>
                    <button class="w-full btn btn-primary">Atualizar Status</button>
                @endif
            </form>
        </div>
    </div>
@endsection
