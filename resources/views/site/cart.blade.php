<x-layouts.site title="Carrinho">
    <h1 class="text-3xl font-extrabold tracking-tight mb-8">Carrinho</h1>

    @cartcount($cartItems)
        @php($totalCart = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']))

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <ul class="card divide-y divide-white/10 lg:col-span-2">
                @foreach($cartItems as $item)
                    <li class="flex items-center gap-4 p-4 sm:p-5">
                        <a href="{{ route('site.single', $item['slug']) }}" class="shrink-0">
                            <x-product-image :path="$item['photo']" :alt="$item['name']" class="size-20 rounded-xl" />
                        </a>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('site.single', $item['slug']) }}" class="font-semibold capitalize hover:text-brand-200">{{ $item['name'] }}</a>
                            <p class="text-sm text-slate-300">{{ $item['quantity'] }} × R$ {{ number_format($item['price'], 2, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold whitespace-nowrap">R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</p>
                        <form action="{{ route('site.cart.remove', ['item' => $item['slug']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-500/15 transition" aria-label="Remover {{ $item['name'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <aside class="card p-6 lg:sticky lg:top-24">
                <h2 class="font-semibold mb-4">Resumo do pedido</h2>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-300">
                        <dt>Itens</dt><dd>{{ collect($cartItems)->sum('quantity') }}</dd>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-white/10 text-lg font-bold text-white">
                        <dt>Total</dt><dd>R$ {{ number_format($totalCart, 2, ',', '.') }}</dd>
                    </div>
                </dl>
                <a href="{{ route('site.checkout.index') }}" class="btn btn-primary btn-lg w-full mt-6">Finalizar compra</a>
                <a href="{{ route('site.home') }}" class="btn btn-ghost w-full mt-2">Continuar comprando</a>
                <a href="{{ route('site.cart.cancel') }}" onclick="return confirm('Esvaziar o carrinho?')"
                    class="block mt-4 text-center text-xs text-slate-400 hover:text-red-600">Esvaziar carrinho</a>
            </aside>
        </div>
    @else
        <div class="card p-12 text-center">
            <div class="mx-auto mb-4 grid place-items-center size-16 rounded-full bg-brand-500/15 text-brand-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </div>
            <h2 class="text-lg font-semibold">Seu carrinho está vazio</h2>
            <p class="mt-1 text-sm text-slate-300">Que tal dar uma olhada nos nossos produtos?</p>
            <a href="{{ route('site.home') }}" class="btn btn-primary mt-6">Ver produtos</a>
        </div>
    @endcartcount
</x-layouts.site>
