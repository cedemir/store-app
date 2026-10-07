@extends('layouts.admin')

@section('title', 'Produtos')

@section('content')
    <x-admin.page-header title="Produtos" :subtitle="$products->total() . ' registro(s)'">
        <a href="{{ route('products.create') }}"
            class="btn btn-primary">
            <x-admin.icon name="plus" class="size-4" /> Novo Produto
        </a>
    </x-admin.page-header>

    <x-admin.search placeholder="Buscar por nome...">
        <select name="status" class="form-input w-auto">
            <option value="">Todos os status</option>
            <option value="active" @selected(request('status') === 'active')>Ativos</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inativos</option>
        </select>
    </x-admin.search>

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-navy-950/40 text-left text-xs uppercase tracking-wide text-slate-300">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Produto</th>
                    <th class="px-4 py-3">Categorias</th>
                    <th class="px-4 py-3 text-right">Preço</th>
                    <th class="px-4 py-3 text-right">Estoque</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-t border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3">{{ $product->id }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($product->thumb)
                                    <img src="{{ asset('storage/' . $product->thumb) }}" alt="" class="size-10 rounded object-cover">
                                @else
                                    <div class="size-10 rounded bg-navy-800 flex items-center justify-center text-slate-400">
                                        <x-admin.icon name="photo" />
                                    </div>
                                @endif
                                <span class="font-medium">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-300">{{ $product->categories->pluck('name')->join(', ') }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">{{ $product->in_stock }}</td>
                        <td class="px-4 py-3">
                            @if($product->is_active)
                                <x-admin.badge color="green">Ativo</x-admin.badge>
                            @else
                                <x-admin.badge color="red">Inativo</x-admin.badge>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('photos.index', $product) }}" title="Fotos"
                                    class="btn btn-secondary btn-sm">
                                    <x-admin.icon name="photo" class="size-4" />
                                </a>
                                <a href="{{ route('products.edit', $product) }}"
                                    class="btn btn-secondary btn-sm">
                                    <x-admin.icon name="pencil" class="size-4" /> Editar
                                </a>
                                <x-admin.delete-button :action="route('products.destroy', $product)" confirm="Remover o produto e suas fotos?" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-slate-300">Nada encontrado!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection
