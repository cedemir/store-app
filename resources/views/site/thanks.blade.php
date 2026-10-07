<x-layouts.site title="Compra concluída">
    <div class="max-w-xl mx-auto card p-8 sm:p-12 text-center">
        <div class="mx-auto mb-6 grid place-items-center size-16 rounded-full bg-emerald-500/15 text-emerald-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Obrigado pela sua compra!</h1>
        <p class="mt-3 text-slate-300">
            Seu pedido foi registrado e está aguardando a confirmação do pagamento.
            Assim que o status mudar, avisaremos você por e-mail.
        </p>

        <div class="mt-6 inline-flex flex-col items-center px-5 py-3 rounded-xl bg-navy-800 ring-1 ring-white/10">
            <span class="text-xs text-slate-300">Código do pedido</span>
            <span class="font-mono text-sm font-semibold">{{ $order->code }}</span>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('customers.my-orders') }}" class="btn btn-primary">Acompanhar pedido</a>
            <a href="{{ route('site.home') }}" class="btn btn-secondary">Continuar comprando</a>
        </div>
    </div>
</x-layouts.site>
