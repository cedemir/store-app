@props(['color' => 'gray'])

@php
    // Classes completas para o Tailwind encontrá-las no scan dos arquivos
    $classes = match ($color) {
        'green'  => 'bg-emerald-500/15 text-emerald-300 ring-emerald-400/30',
        'red'    => 'bg-red-500/15 text-red-300 ring-red-400/30',
        'blue'   => 'bg-sky-500/15 text-sky-300 ring-sky-400/30',
        'yellow' => 'bg-amber-500/15 text-amber-300 ring-amber-400/30',
        'purple' => 'bg-violet-500/15 text-violet-300 ring-violet-400/30',
        default  => 'bg-white/10 text-slate-200 ring-white/20',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium ring-1 ring-inset $classes"]) }}>
    <span class="size-1.5 rounded-full bg-current opacity-70"></span>
    {{ $slot }}
</span>
