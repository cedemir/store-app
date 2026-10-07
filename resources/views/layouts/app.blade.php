<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loja - Code Experts</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="w-full mb-10 flex justify-between bg-gray-900 px-4">
        <a href="/admin/products" class="text-white py-4">Experts Store 12</a>
        <ul class="flex">
            <li class="py-4">
                <a href="{{ route('products.index') }}"
                    class="text-white px-6 py-4 hover:bg-purple-800 transition ease-in-out duration-300">Produtos</a>
            </li>
            <li class="py-4">
                <a href="{{ route('categories.index') }}"
                    class="text-white px-6 py-4 hover:bg-purple-800 transition ease-in-out duration-300">Categorias</a>
            </li>
            <li class="py-4">
                <a href="{{ route('orders.index') }}"
                    class="text-white px-6 py-4 hover:bg-purple-800 transition ease-in-out duration-300">Pedidos</a>
            </li>
            <li class="py-4">
                <a href="{{ route('users.index') }}"
                    class="text-white px-6 py-4 hover:bg-purple-800 transition ease-in-out duration-300">Usuários</a>
            </li>
            <li class="py-4">
                <form action="{{ route('logout') }}" method="post" id="logout">@csrf</form>
                <a href="#"
                    class="px-6 py-4 bg-red-800 hover:bg-red-950 text-white transition ease-in-out duration-300"
                    onclick="event.preventDefault(); document.querySelector('form#logout').submit()">Sair</a>
            </li>
            <li class="py-4">
                <span class=" font-thin ml-4 text-white">Olá, {{ str(auth()->user()->name)->explode(' ')[0] }}</span>
            </li>
        </ul>
    </nav>
    <div id="container" class="max-w-7xl mx-auto p-6">
        @include('includes.messages')

        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
