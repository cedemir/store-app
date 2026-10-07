<x-layouts.site title="Meus Pedidos">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight">Meus Pedidos</h1>
        <p class="text-slate-300">Olá, {{ str(request()->user()->name)->explode(' ')->first() }}! Acompanhe aqui suas compras.</p>
    </div>

    <div class="space-y-6">
        @forelse($orders as $order)
            <article class="card overflow-hidden">
                <header class="flex flex-wrap items-center justify-between gap-3 px-5 sm:px-6 py-4 bg-navy-950/40 border-b border-white/10">
                    <div>
                        <p class="text-xs text-slate-300">Pedido realizado em {{ $order->created_at?->format('d/m/Y H:i') }}</p>
                        <p class="font-mono text-sm font-medium">{{ $order->code }}</p>
                    </div>
                    <x-admin.badge :color="$order->status->color()">{{ $order->status->status() }}</x-admin.badge>
                </header>

                <ul class="divide-y divide-white/10 px-5 sm:px-6">
                    @foreach($order->items as $item)
                        <li class="flex items-center gap-4 py-4">
                            <x-product-image :path="$item->product?->thumb" :alt="$item->product?->name" class="size-14 rounded-lg" />
                            <div class="flex-1 min-w-0">
                                <p class="font-medium capitalize truncate">{{ $item->product?->name }}</p>
                                <p class="text-sm text-slate-300">{{ $item->quantity }} × R$ {{ number_format($item->product?->price, 2, ',', '.') }}</p>
                            </div>
                            <p class="font-medium whitespace-nowrap">R$ {{ number_format($item->quantity * $item->product?->price, 2, ',', '.') }}</p>
                        </li>
                    @endforeach
                </ul>

                <footer class="flex flex-wrap items-center justify-between gap-3 px-5 sm:px-6 py-4 border-t border-white/10">
                    <p class="text-sm text-slate-300">Total: <span class="text-lg font-bold text-white">R$ {{ number_format($order->totalOrder(), 2, ',', '.') }}</span></p>

                    @if($order->status->name !== 'CUSTOMER_CANCELLED')
                        <form action="{{ route('customers.my-orders.cancel', $order) }}" method="POST"
                            onsubmit="return confirm('Deseja realmente cancelar este pedido?')">
                            @method('PUT')
                            @csrf
                            <button class="btn btn-sm bg-navy-900 text-red-400 ring-1 ring-red-500/40 hover:bg-red-500/15">Cancelar pedido</button>
                        </form>
                    @endif
                </footer>
            </article>
        @empty
            <div class="card p-12 text-center">
                <h2 class="text-lg font-semibold">Você ainda não fez nenhum pedido</h2>
                <p class="mt-1 text-sm text-slate-300">Quando fizer uma compra, ela aparecerá aqui.</p>
                <a href="{{ route('site.home') }}" class="btn btn-primary mt-6">Ver produtos</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $orders->links() }}</div>
</x-layouts.site>
