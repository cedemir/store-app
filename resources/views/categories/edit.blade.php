@extends('layouts.app')

@section('content')
    <form action="{{ route('categories.update', ['category' => $category->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="w-full mb-6">
            <label class="block mb-2 @error('name') text-red-900 @enderror">Nome</label>
            <input type="text" name="name" class="w-full p-2 rounded border @error('name') border-red-900 @else border-gray-900 @enderror"
                value="{{ $category->name }}">

            @error('name')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label class="block mb-2  @error('description') text-red-900 @enderror">Descrição</label>
            <input type="text" name="description" class="w-full p-2 rounded border @error('description') border-red-900 @else border-gray-900 @enderror"
                value="{{ $category->description }}">

            @error('description')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label class="block mb-2  @error('slug') text-red-900 @enderror">Slug</label>
            <input type="text" name="slug" class="w-full p-2 rounded border @error('slug') border-red-900 @else border-gray-900 @enderror"
                value="{{ $category->slug }}">

            @error('slug')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror
        </div>

        <button class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Atualizar
            Categoria</button>
    </form>

    <form action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2 bg-red-700 border border-red-900 rounded text-white font-thin mt-8">Remover
            Categoria</button>
    </form>
@endsection
