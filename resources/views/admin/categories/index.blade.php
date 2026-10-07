@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')
    <x-admin.page-header title="Categorias" :subtitle="$categories->total() . ' registro(s)'">
        <a href="{{ route('categories.create') }}"
            class="btn btn-primary">
            <x-admin.icon name="plus" class="size-4" /> Nova Categoria
        </a>
    </x-admin.page-header>

    <x-admin.search placeholder="Buscar por nome..." />

    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-navy-950/40 text-left text-xs uppercase tracking-wide text-slate-300">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Produtos</th>
                    <th class="px-4 py-3">Criada em</th>
                    <th class="px-4 py-3 text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-t border-white/10 hover:bg-white/5">
                        <td class="px-4 py-3">{{ $category->id }}</td>
                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-slate-300">{{ $category->slug }}</td>
                        <td class="px-4 py-3">{{ $category->products_count }}</td>
                        <td class="px-4 py-3">{{ $category->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('categories.edit', $category) }}"
                                    class="btn btn-secondary btn-sm">
                                    <x-admin.icon name="pencil" class="size-4" /> Editar
                                </a>
                                <x-admin.delete-button :action="route('categories.destroy', $category)"
                                    confirm="Remover a categoria? Os produtos não serão removidos." />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-slate-300">Nada encontrado!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
@endsection
