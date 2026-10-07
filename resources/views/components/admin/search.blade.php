@props(['placeholder' => 'Buscar...'])

<form method="get" class="w-full mb-4 flex flex-wrap gap-2">
    <div class="relative flex-1 min-w-48">
        <x-admin.icon name="search" class="size-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" />
        <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder }}" class="form-input pl-10">
    </div>
    {{ $slot }}
    <button class="btn btn-secondary">Filtrar</button>
    @if(request()->hasAny(['q', 'status']))
        <a href="{{ url()->current() }}" class="btn btn-ghost">Limpar</a>
    @endif
</form>
