@php
    $menu = [
        ['label' => 'Dashboard',  'route' => 'admin.dashboard',  'active' => 'admin.dashboard',          'icon' => 'home'],
        ['label' => 'Produtos',   'route' => 'products.index',   'active' => ['products.*', 'photos.*'], 'icon' => 'cube'],
        ['label' => 'Categorias', 'route' => 'categories.index', 'active' => 'categories.*',             'icon' => 'tag'],
        ['label' => 'Pedidos',    'route' => 'orders.index',     'active' => 'orders.*',                 'icon' => 'bag'],
        ['label' => 'Usuários',   'route' => 'users.index',      'active' => 'users.*',                  'icon' => 'users'],
    ];
@endphp
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@hasSection('title')@yield('title') · @endif Admin · Experts Store</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen">
    {{-- Barra superior (mobile) --}}
    <header class="lg:hidden sticky top-0 z-50 flex items-center justify-between h-16 px-4 bg-navy-950/80 backdrop-blur-lg border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}"><x-logo /></a>
        <button type="button" id="menuToggle" class="p-2 rounded-lg text-slate-200 hover:bg-white/10" aria-label="Abrir menu"
            aria-controls="sidebar" aria-expanded="false">
            <x-admin.icon name="menu" class="size-6" />
        </button>
    </header>

    <div class="flex">
        {{-- Menu lateral --}}
        <aside id="sidebar"
            class="hidden lg:flex flex-col w-full lg:w-72 shrink-0 bg-navy-900 border-r border-white/10 overflow-y-auto
                   fixed lg:sticky top-16 lg:top-0 bottom-0 inset-x-0 lg:h-screen z-40">
            <div class="hidden lg:flex items-center h-16 px-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}"><x-logo /></a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1">
                <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Gerenciar</p>
                @foreach($menu as $item)
                    @php($isActive = request()->routeIs(...(array) $item['active']))
                    <a href="{{ route($item['route']) }}"
                        @class([
                            'group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition',
                            'bg-brand-500/15 text-brand-300' => $isActive,
                            'text-slate-200 hover:bg-white/10 hover:text-white' => !$isActive,
                        ])
                        @if($isActive) aria-current="page" @endif>
                        <x-admin.icon :name="$item['icon']"
                            @class(['size-5', 'text-brand-400' => $isActive, 'text-slate-400 group-hover:text-white' => !$isActive]) />
                        {{ $item['label'] }}
                    </a>
                @endforeach

                <p class="px-3 pt-6 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Loja</p>
                <a href="{{ route('site.home') }}" target="_blank"
                    class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-200 hover:bg-white/10 hover:text-white transition">
                    <x-admin.icon name="store" class="size-5 text-slate-400 group-hover:text-white" />
                    Ver loja
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 p-2">
                    <span class="grid place-items-center size-9 rounded-full bg-brand-500/20 text-brand-300 text-sm font-semibold shrink-0">
                        {{ str(auth()->user()->name)->substr(0, 1)->upper() }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-300 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-500/15 transition" title="Sair" aria-label="Sair">
                            <x-admin.icon name="logout" />
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Conteúdo --}}
        <main class="flex-1 min-w-0 px-4 py-6 sm:px-8 sm:py-10">
            <div class="max-w-7xl mx-auto">
                <x-flash />

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.getElementById('menuToggle')?.addEventListener('click', e => {
            const sidebar = document.getElementById('sidebar');
            const open = sidebar.classList.toggle('hidden') === false;
            sidebar.classList.toggle('flex', open);
            e.currentTarget.setAttribute('aria-expanded', open);
        });
    </script>
    @stack('scripts')
</body>

</html>
