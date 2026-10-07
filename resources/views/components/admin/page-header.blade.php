@props(['title', 'subtitle' => null, 'back' => null])

<div class="w-full mb-8 flex flex-wrap items-end justify-between gap-4">
    <div class="min-w-0">
        @if($back)
            <a href="{{ $back }}" class="inline-flex items-center gap-1 mb-2 text-sm text-slate-300 hover:text-brand-200 transition">
                <x-admin.icon name="back" class="size-4" /> Voltar
            </a>
        @endif
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white truncate">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-1 text-sm text-slate-300">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="flex flex-wrap items-center gap-2">
        {{ $slot }}
    </div>
</div>
