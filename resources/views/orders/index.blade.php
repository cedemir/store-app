@extends('layouts.app')

@section('content')
    <div class="w-full mb-10 flex justify-between">
        <h2 class="font-bold text-xl">Pedidos</h2>
    </div>
    <div class="w-full p-5">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-600">
                    <th class="px-4 py-2 text-xl text-left">#</th>
                    <th class="px-4 py-2 text-xl text-left">Código</th>
                    <th class="px-4 py-2 text-xl text-left">Cliente</th>
                    <th class="px-4 py-2 text-xl text-left">Status</th>
                    <th class="px-4 py-2 text-xl text-left">Total</th>
                    <th class="px-4 py-2 text-xl text-left">Criado em</th>
                    <th class="px-4 py-2 text-xl text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-2 text-normal text-left">{{ $order->id }}</td>
                        <td class="px-4 py-2 text-normal text-left font-mono text-sm">{{ $order->code }}</td>
                        <td class="px-4 py-2 text-normal text-left">{{ $order->customer?->name }}</td>
                        <td class="px-4 py-2 text-normal text-left text-{{ $order->status->color() }}-800">
                            {{ $order->status->status() }}
                        </td>
                        <td class="px-4 py-2 text-normal text-left">R$ {{ number_format($order->totalOrder(), 2, ',', '.') }}</td>
                        <td class="px-4 py-2 text-normal text-left">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="w-[15%] px-4 py-2 text-normal text-left">
                            <div class="flex justify-around gap-x-2">
                                <a href="{{ route('orders.edit', ['order' => $order->id]) }}"
                                    class="px-4 py-2 bg-blue-700 border border-blue-900 rounded text-white font-thin">
                                    Editar
                                </a>
                                <form action="{{ route('orders.destroy', ['order' => $order->id]) }}" method="post"
                                    onsubmit="return confirm('Deseja realmente remover este pedido?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-700 border border-red-900 rounded text-white font-thin">Remover</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Nada encontrado!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="w-full mt-10">
        {{ $orders->links() }}
    </div>
@endsection
