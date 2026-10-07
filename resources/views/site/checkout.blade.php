<x-layouts.site title="Pagamento">
    @inject('cart', \App\Services\CartService::class)
    @php
        $cartItems = $cart->all();
        $totalCart = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
    @endphp

    <h1 class="text-3xl font-extrabold tracking-tight mb-8">Pagamento</h1>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
        <form action="{{ route('site.checkout.process') }}" method="POST" class="card p-6 sm:p-8 lg:col-span-3">
            @csrf
            <h2 class="font-semibold mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-brand-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                Cartão de crédito
            </h2>

            <div class="mb-5">
                <label for="card_number" class="form-label">Número do cartão</label>
                <input type="text" name="card_number" id="card_number" placeholder="0000 0000 0000 0000" inputmode="numeric" autocomplete="cc-number" required class="form-input">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <div>
                    <label for="card_date" class="form-label">Validade</label>
                    <input type="text" name="card_date" id="card_date" placeholder="MM/AA" autocomplete="cc-exp" required class="form-input">
                </div>
                <div>
                    <label for="card_cvv" class="form-label">CVV</label>
                    <input type="text" name="card_cvv" id="card_cvv" placeholder="123" inputmode="numeric" autocomplete="cc-csc" required class="form-input">
                </div>
            </div>

            <button class="btn btn-primary btn-lg w-full" @disabled(!count($cartItems))>
                Pagar R$ {{ number_format($totalCart, 2, ',', '.') }}
            </button>
            <p class="mt-4 flex items-center justify-center gap-1.5 text-xs text-slate-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
                Pagamento processado com segurança
            </p>
        </form>

        <aside class="card p-6 lg:col-span-2">
            <h2 class="font-semibold mb-4">Resumo</h2>
            <ul class="divide-y divide-white/10">
                @forelse($cartItems as $item)
                    <li class="flex items-center gap-3 py-3">
                        <x-product-image :path="$item['photo']" :alt="$item['name']" class="size-12 rounded-lg" />
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium capitalize truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-slate-300">Qtd.: {{ $item['quantity'] }}</p>
                        </div>
                        <p class="text-sm font-medium">R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</p>
                    </li>
                @empty
                    <li class="py-3 text-sm text-slate-300">Seu carrinho está vazio. <a href="{{ route('site.home') }}" class="text-brand-300 underline">Ver produtos</a></li>
                @endforelse
            </ul>
            <div class="flex justify-between pt-4 mt-2 border-t border-white/10 text-lg font-bold">
                <span>Total</span><span>R$ {{ number_format($totalCart, 2, ',', '.') }}</span>
            </div>
        </aside>
    </div>
</x-layouts.site>
