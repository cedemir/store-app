@props(['title' => null])

@php
    $cartCount = count(session('cart', []));
    $links = [
        ['label' => 'Produtos',     'route' => 'site.home',           'active' => 'site.home'],
        ['label' => 'Meus Pedidos', 'route' => 'customers.my-orders', 'active' => 'customers.*'],
    ];
@endphp
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ? $title . ' · ' : '' }}Experts Store</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">
    <header class="sticky top-0 z-40 bg-navy-950/80 backdrop-blur-lg border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('site.home') }}"><x-logo /></a>

            <nav class="hidden md:flex items-center gap-1">
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}"
                        @class([
                            'px-3 py-2 rounded-lg text-sm font-medium transition',
                            'text-brand-300 bg-brand-500/15' => request()->routeIs($link['active']),
                            'text-slate-200 hover:text-white hover:bg-white/10' => !request()->routeIs($link['active']),
                        ])>{{ $link['label'] }}</a>
                @endforeach
                @can('can_access_manager')
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Painel</a>
                @endcan
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('site.cart.index') }}" class="relative p-2 rounded-lg text-slate-200 hover:text-white hover:bg-white/10 transition" aria-label="Carrinho">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    @if($cartCount)
                        <span class="absolute -top-0.5 -right-0.5 grid place-items-center min-w-5 h-5 px-1 rounded-full bg-brand-600 text-white text-[11px] font-bold ring-2 ring-navy-950">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <details class="relative group">
                        <summary class="list-none flex items-center gap-2 p-1 pr-2 rounded-full hover:bg-white/10 cursor-pointer transition [&::-webkit-details-marker]:hidden">
                            <span class="grid place-items-center size-8 rounded-full bg-brand-500/20 text-brand-300 text-sm font-semibold">
                                {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                            </span>
                            <span class="hidden sm:block text-sm font-medium text-white">{{ str(auth()->user()->name)->explode(' ')->first() }}</span>
                        </summary>
                        <div class="absolute right-0 mt-2 w-56 card p-1.5 shadow-lg">
                            <div class="px-3 py-2 border-b border-white/10 mb-1">
                                <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-300 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('customers.my-orders') }}" class="block px-3 py-2 rounded-lg text-sm text-white hover:bg-white/10">Meus Pedidos</a>
                            @can('can_access_manager')
                                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-white hover:bg-white/10">Painel administrativo</a>
                            @endcan
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="w-full text-left px-3 py-2 rounded-lg text-sm text-red-400 hover:bg-red-500/15">Sair</button>
                            </form>
                        </div>
                    </details>
                @else
                    <a href="{{ route('login.view') }}" class="btn btn-primary btn-sm">Entrar</a>
                @endauth
            </div>
        </div>

        {{-- Navegação mobile --}}
        <nav class="md:hidden flex gap-1 px-4 pb-2 overflow-x-auto">
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                    @class([
                        'px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap',
                        'text-brand-300 bg-brand-500/15' => request()->routeIs($link['active']),
                        'text-slate-200' => !request()->routeIs($link['active']),
                    ])>{{ $link['label'] }}</a>
            @endforeach
            @can('can_access_manager')
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg text-sm font-medium text-slate-200 whitespace-nowrap">Painel</a>
            @endcan
        </nav>
    </header>

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <x-flash />

        {{ $slot }}
    </main>

    <footer class="border-t border-white/10 bg-navy-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <x-logo class="text-sm" />
            <p class="text-sm text-slate-300">&copy; {{ date('Y') }} Experts Store. Todos os direitos reservados.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
