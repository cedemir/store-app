@extends('layouts.app')

@section('content')
    <div class="w-full mb-10 flex justify-between">
        <h2 class="font-bold text-xl">Produtos</h2>
        <a href="{{ route('products.create') }}"
            class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Criar Produto</a>
    </div>
    <div class="w-full p-5">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-600">
                    <th class="px-4 py-2 text-xl text-left">#</th>
                    <th class="px-4 py-2 text-xl text-left">Produto</th>
                    <th class="px-4 py-2 text-xl text-left">Status</th>
                    <th class="px-4 py-2 text-xl text-left">Criado em</th>
                    <th class="px-4 py-2 text-xl text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="px-4 py-2 text-normal text-left">{{ $product->id }}</td>
                        <td class="px-4 py-2 text-normal text-left">{{ $product->name }}</td>
                        <td class="px-4 py-2 text-normal text-left">
                            @if ($product->is_active)
                                <span class="p-1 rounded bg-green-500 text-green-900">Ativo</span>
                            @else
                                <span class="p-1 rounded bg-red-500 text-red-900">Inativo</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-normal text-left">{{ $product->created_at->format('d/m/Y H:i') }}</td>
                        <td class="w-[15%] px-4 py-2 text-normal text-left">
                            <div class="flex justify-around gap-x-2">
                                <a href="{{ route('products.show', ['product' => $product->id]) }}"
                                    class="px-4 py-2 bg-blue-700 border border-blue-900 rounded text-white font-thin">
                                    Editar
                                </a>
                                <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="post">
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
                        <td colspan="4">Nada encontrado!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="w-full mt-10">
        {{ $products->links() }}
    </div>
@endsection
