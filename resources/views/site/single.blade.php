<x-layouts.site :title="$product->name">
    @php($photos = $product->photos)

    <nav class="mb-6 text-sm text-slate-300" aria-label="Breadcrumb">
        <a href="{{ route('site.home') }}" class="hover:text-white">Produtos</a>
        <span class="mx-2">/</span>
        <span class="text-white capitalize">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        {{-- Galeria --}}
        <div>
            <div class="card overflow-hidden aspect-square">
                <x-product-image :path="$photos->first()?->photo" :alt="$product->name" class="size-full" id="mainPhoto" />
            </div>

            @if($photos->count() > 1)
                <div class="mt-4 grid grid-cols-5 gap-3">
                    @foreach($photos as $photo)
                        <button type="button" data-src="{{ asset('storage/' . $photo->photo) }}"
                            @class(['photoThumb aspect-square rounded-xl overflow-hidden ring-2 transition cursor-pointer',
                                    'ring-brand-500' => $loop->first, 'ring-transparent hover:ring-white/30' => !$loop->first])>
                            <img src="{{ asset('storage/' . $photo->photo) }}" alt="" class="size-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Informações --}}
        <div class="lg:py-4">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight capitalize">{{ $product->name }}</h1>
            <p class="mt-3 text-lg text-slate-300">{{ $product->description }}</p>

            <p class="mt-6 text-4xl font-bold tracking-tight">R$ {{ number_format($product->price, 2, ',', '.') }}</p>

            <div class="mt-3">
                @if($product->in_stock > 0)
                    <x-admin.badge color="green">Em estoque</x-admin.badge>
                @else
                    <x-admin.badge color="red">Indisponível</x-admin.badge>
                @endif
            </div>

            <form action="{{ route('site.cart.add') }}" method="post" class="mt-8 card p-5">
                @csrf
                <input type="hidden" name="cart[product]" value="{{ $product->slug }}">

                <label for="quantity" class="form-label">Quantidade</label>
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center rounded-xl ring-1 ring-white/20 overflow-hidden">
                        <button type="button" class="px-4 py-3 text-slate-200 hover:bg-white/10" data-step="-1" aria-label="Diminuir">−</button>
                        <input type="number" min="1" name="cart[quantity]" id="quantity" value="1" required
                            class="w-14 text-center border-0 focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none">
                        <button type="button" class="px-4 py-3 text-slate-200 hover:bg-white/10" data-step="1" aria-label="Aumentar">+</button>
                    </div>
                    <button class="btn btn-primary btn-lg flex-1" @disabled($product->in_stock <= 0)>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        Adicionar ao carrinho
                    </button>
                </div>
                @error('cart.product') <p class="form-error">{{ $message }}</p> @enderror
                @error('cart.quantity') <p class="form-error">{{ $message }}</p> @enderror
            </form>

            @if($product->body)
                <div class="mt-10">
                    <h2 class="text-lg font-semibold mb-3">Sobre o produto</h2>
                    <div class="text-slate-200 leading-relaxed whitespace-pre-line">{{ $product->body }}</div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            const mainPhoto = document.getElementById('mainPhoto');
            document.querySelectorAll('.photoThumb').forEach(thumb => {
                thumb.addEventListener('click', () => {
                    if (mainPhoto) mainPhoto.src = thumb.dataset.src;
                    document.querySelectorAll('.photoThumb').forEach(t => {
                        t.classList.toggle('ring-brand-500', t === thumb);
                        t.classList.toggle('ring-transparent', t !== thumb);
                    });
                });
            });

            const qty = document.getElementById('quantity');
            document.querySelectorAll('[data-step]').forEach(btn => {
                btn.addEventListener('click', () => {
                    qty.value = Math.max(1, (parseInt(qty.value) || 1) + parseInt(btn.dataset.step));
                });
            });
        </script>
    @endpush
</x-layouts.site>
