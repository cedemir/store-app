<x-layouts.site title="Produtos">
    {{-- Destaque --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-600 via-brand-700 to-brand-950 px-6 py-12 sm:px-12 sm:py-16 mb-12 text-white">
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-24 right-40 size-64 rounded-full bg-brand-400/30 blur-3xl" aria-hidden="true"></div>
        <div class="relative max-w-2xl">
            <span class="inline-block mb-4 px-3 py-1 rounded-full bg-white/15 text-xs font-medium ring-1 ring-white/20">Novidades toda semana</span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">Tudo o que você precisa, em um só lugar.</h1>
            <p class="mt-4 text-base sm:text-lg text-brand-100">Confira os produtos selecionados da Experts Store e compre com poucos cliques.</p>
            <a href="#produtos" class="btn btn-lg mt-8 bg-white text-navy-900 hover:bg-brand-50">Ver produtos</a>
        </div>
    </section>

    <div id="produtos" class="flex items-end justify-between mb-6 scroll-mt-24">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Produtos</h2>
            <p class="text-sm text-slate-300">{{ $products->count() }} produto(s) disponível(is)</p>
        </div>
    </div>

    @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a href="{{ route('site.single', ['product' => $product->slug]) }}"
                    class="group card overflow-hidden flex flex-col hover:shadow-xl hover:shadow-black/40 hover:-translate-y-1 transition duration-300">
                    <div class="aspect-square overflow-hidden bg-navy-800">
                        <x-product-image :path="$product->thumb" :alt="$product->name"
                            class="size-full group-hover:scale-105 transition duration-500" />
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-semibold capitalize text-white group-hover:text-brand-300 transition">{{ $product->name }}</h3>
                        <p class="mt-1 text-sm text-slate-300 line-clamp-2">{{ $product->description }}</p>
                        <div class="mt-auto pt-4 flex items-center justify-between">
                            <span class="text-xl font-bold tracking-tight">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                            <span class="grid place-items-center size-9 rounded-full bg-brand-500/15 text-brand-300 group-hover:bg-brand-600 group-hover:text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="card p-12 text-center text-slate-300">Nenhum produto disponível no momento.</div>
    @endif
</x-layouts.site>
