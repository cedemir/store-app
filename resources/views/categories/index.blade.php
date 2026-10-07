@extends('layouts.app')

@section('content')
    <div class="w-full mb-10 flex justify-between">
        <h2 class="font-bold text-xl">Categorias</h2>
        <a href="{{ route('categories.create') }}"
            class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Criar Categoria</a>
    </div>
    <div class="w-full p-5">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-600">
                    <th class="px-4 py-2 text-xl text-left">#</th>
                    <th class="px-4 py-2 text-xl text-left">Categoria</th>
                    <th class="px-4 py-2 text-xl text-left">Criado em</th>
                    <th class="px-4 py-2 text-xl text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="px-4 py-2 text-normal text-left">{{ $category->id }}</td>
                        <td class="px-4 py-2 text-normal text-left">{{ $category->name }}</td>
                        <td class="px-4 py-2 text-normal text-left">{{ $category->created_at->format('d/m/Y H:i') }}</td>
                        <td class="w-[15%] px-4 py-2 text-normal text-left">
                            <div class="flex justify-around gap-x-2">
                                <a href="{{ route('categories.show', ['category' => $category->id]) }}"
                                    class="px-4 py-2 bg-blue-700 border border-blue-900 rounded text-white font-thin">
                                    Editar
                                </a>
                                <form action="{{ route('categories.destroy', ['category' => $category->id]) }}"
                                    method="post">
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
        {{ $categories->links() }}
    </div>
@endsection
