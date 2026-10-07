@extends('layouts.app')

@section('content')
    <div class="mb-10">
        &raquo; <a href="{{route('products.edit', ['product' => $product->id])}}" class="text-sm underline">Edição Produto</a>
    </div>
    <div class="w-full mx-auto">
        <form action="{{ route('photos.store', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="w-full mb-6">
                <label class="block mb-2 @error('photos.*') text-red-900 @enderror">Selecione as fotos do produto abaixo:</label>
                <input type="file" name="photos[]" class="w-full p-2 rounded border @error('photos.*') border-red-900 @else border-gray-900 @enderror" multiple required>

                @error('photos.*')
                    <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
                @enderror
            </div>


            <button class="px-4 py-2 bg-green-700 border border-green-900 rounded text-white font-thin">Salvar Fotos</button>
        </form>
    </div>
    <div class="w-full mx-auto mt-10">
        @if($product->photos->count())
            <div class="grid grid-cols-5 gap-x-3 border-t border-gray-400 py-4">
                @foreach($product->photos as $photo)
                    <div class="relative group">
                        <form action="{{route('photos.destroy', ['product' => $product->id, 'photo' => $photo->id])}}" id="submitDestroy{{$photo->id}}" method="post">@csrf @method('DELETE')</form>

                        <button class="absolute top-1 right-1 text-white bg-red-700 p-2 rounded cursor-pointer hidden group-hover:block" id="destroyPhoto" data-photo="{{$photo->id}}">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                              </svg>

                        </button>

                        <img src="{{asset('storage/' . $photo->photo)}}" alt="" class="p-1 rounded shadow bg-white">
                    </div>
                @endforeach
            </div>
        @else
        <div class="w-full mt-4 text-red-700">
            Sem fotos para este produto!
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        const button = document.querySelectorAll('button#destroyPhoto')

        button.forEach(el => {
            console.log(el)
            el.addEventListener('click', e => {
                e.preventDefault();

                if(!confirm('Deseja mesmo remover a foto?')) return;

                const photoId = el.dataset.photo;

                document.querySelector(`form#submitDestroy${photoId}`).submit();
            })
        });
    </script>
    @endpush
@endsection
