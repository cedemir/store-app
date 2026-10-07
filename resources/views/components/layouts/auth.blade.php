@props(['title', 'subtitle' => null])
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} · Experts Store</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen grid lg:grid-cols-2">
    {{-- Painel de marca --}}
    <aside class="hidden lg:flex relative overflow-hidden flex-col justify-between p-12 bg-gradient-to-br from-brand-600 via-brand-800 to-brand-950 text-white">
        <div class="absolute -left-24 -top-24 size-96 rounded-full bg-white/10 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-32 -right-16 size-96 rounded-full bg-brand-400/30 blur-3xl" aria-hidden="true"></div>

        <a href="{{ route('site.home') }}" class="relative"><x-logo /></a>

        <div class="relative max-w-md">
            <h2 class="text-4xl font-extrabold tracking-tight leading-tight">Compre com praticidade, acompanhe com tranquilidade.</h2>
            <p class="mt-4 text-brand-100">Acesse sua conta para finalizar compras, acompanhar pedidos e gerenciar a loja.</p>
        </div>

        <p class="relative text-sm text-brand-200">&copy; {{ date('Y') }} Experts Store</p>
    </aside>

    {{-- Formulário --}}
    <main class="flex flex-col items-center justify-center px-4 py-12 sm:px-8">
        <div class="w-full max-w-sm">
            <a href="{{ route('site.home') }}" class="lg:hidden inline-block mb-10"><x-logo /></a>

            <h1 class="text-2xl font-bold tracking-tight">{{ $title }}</h1>
            @if($subtitle)
                <p class="mt-1 text-sm text-slate-300">{{ $subtitle }}</p>
            @endif

            <div class="mt-8">
                <x-flash />
                {{ $slot }}
            </div>
        </div>
    </main>
</body>
</html>
