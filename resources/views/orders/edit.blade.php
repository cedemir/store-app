@extends('layouts.app')

@section('content')
    <div class="w-full mb-10">
        <h2 class="font-bold text-xl mb-4">Pedido {{ $order->code }}</h2>
        <p><strong>Cliente:</strong> {{ $order->customer?->name }} ({{ $order->customer?->email }})</p>
        <p><strong>Criado em:</strong> {{ $order->created_at?->format('d/m/Y H:i') }}</p>
        @if($order->gateway_code)
            <p><strong>Código no gateway:</strong> {{ $order->gateway_code }}</p>
        @endif
    </div>

    <div class="w-full mb-10">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-600">
                    <th class="px-4 py-2 text-left">Produto</th>
                    <th class="px-4 py-2 text-left">Preço</th>
                    <th class="px-4 py-2 text-left">Quantidade</th>
                    <th class="px-4 py-2 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->product?->name }}</td>
                        <td class="px-4 py-2">R$ {{ number_format($item->product?->price, 2, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">R$ {{ number_format($item->quantity * $item->product?->price, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-gray-600">
                    <td colspan="3" class="px-4 py-2 text-right font-bold">Total</td>
                    <td class="px-4 py-2 font-bold">R$ {{ number_format($order->totalOrder(), 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <form action="{{ route('orders.update', ['order' => $order->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="w-full mb-6">
            <label class="block mb-2 @error('status') text-red-900 @enderror">Status</label>
            <select name="status" @disabled($order->status->name === 'CUSTOMER_CANCELLED')
                class="w-full p-2 rounded border @error('status') border-red-900 @else border-gray-900 @enderror">
                @foreach($statuses as $status)
                    <option value="{{ $status->name }}" @selected(old('status', $order->status->name) === $status->name)>
                        {{ $status->status() }}
                    </option>
                @endforeach
            </select>

            @error('status')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror
        </div>

        @if($order->status->name !== 'CUSTOMER_CANCELLED')
            <button class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Atualizar
                Pedido</button>
        @endif
    </form>

    <form action="{{ route('orders.destroy', ['order' => $order->id]) }}" method="post"
        onsubmit="return confirm('Deseja realmente remover este pedido?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-700 border border-red-900 rounded text-white font-thin mt-8">Remover
            Pedido</button>
    </form>
@endsection
