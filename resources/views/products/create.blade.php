@extends('layouts.app')

@section('content')
    <form action="{{ route('products.store') }}" method="post">
        @csrf

        <div class="w-full mb-6">
            <label class="block mb-2 @error('name') text-red-900 @enderror">Nome</label>
            <input type="text" name="name" class="w-full p-2 rounded border @error('name') border-red-900 @else border-gray-900 @enderror" value="{{ old('name') }}">

            @error('name')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label  class="block mb-2 @error('description') text-red-900 @enderror">Descrição</label>
            <input type="text" name="description" class="w-full p-2 rounded border  @error('description') border-red-900 @else border-gray-900 @enderror"
                value="{{ old('description') }}">

            @error('description')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label class="block mb-2 @error('body') text-red-900 @enderror">Conteúdo</label>
            <textarea name="body" id="" cols="30" rows="10" class="w-full p-2 rounded border @error('body') border-red-900 @else border-gray-900 @enderror">{{ old('body') }}</textarea>

            @error('body')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror

        </div>

        <div class="w-full mb-6 flex gap-x-4">
            <div class="w-[50%]">
                <label class="block mb-2 @error('price') text-red-900 @enderror">Preço</label>
                <input type="text" name="price" class="w-full p-2 rounded border @error('price') border-red-900 @else border-gray-900 @enderror"
                value="{{ old('price') }}">

                @error('price')
                    <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
                @enderror
            </div>
            <div class="w-[50%]">
                <label class="block mb-2 @error('in_stock') text-red-900 @enderror">Estoque</label>
                <input type="numer" name="in_stock" class="w-full p-2 rounded border @error('in_stock') border-red-900 @else border-gray-900 @enderror"
                value="{{ old('in_stock') }}">

                @error('in_stock')
                    <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="w-full mb-6">
            <label class="block mb-2 @error('slug') text-red-900 @enderror">Slug</label>
            <input type="text" name="slug" class="w-full p-2 rounded border @error('slug') border-red-900 @else border-gray-900 @enderror"
                value="{{ old('slug') }}">

            @error('slug')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror
        </div>

        <div class="w-full mb-6">
            <label class="w-full mb-4 @error('is_active') text-red-900 @enderror">Status</label>

            <div class="w-full mb-6">
                <select name="is_active" class="w-full p-2 rounded border @error('is_active') border-red-900 @else border-gray-900 @enderror">
                    <option value="">Selecione o status do produto</option>
                    <option value="1" @selected(old('is_active'))>Ativo</option>
                    <option value="0" @selected(!old('is_active'))>Inativo</option>
                </select>

                @error('is_active')
                    <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
                @enderror
            </div>
        </div>

        <div class="w-full mb-6">

            @error('categories')
                <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
            @enderror

            <label class="w-full mb-4 @error('categories') text-red-900 @enderror">Categorias</label>

            <div class="px-5 grid grid-cols-3">
                @foreach ($categories as $category)
                    <div>
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        {{ $category->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <button class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Criar Produto</button>
    </form>
@endsection
