@props([
    'name'=> null
])
<div class="w-full p-2 bg-white">

    {{$header}}
    <hr>

    <h1>Olá, {{$name}} - Hello World!</h1>

    <hr>
    {{ $slot }}
</div>
