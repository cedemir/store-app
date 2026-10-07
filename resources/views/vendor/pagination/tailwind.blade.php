{{-- Paginação no tema azul-marinho (substitui a view padrão do Laravel) --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginação" class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-slate-300">
            @if ($paginator->firstItem())
                Mostrando <span class="font-semibold text-white">{{ $paginator->firstItem() }}</span>
                a <span class="font-semibold text-white">{{ $paginator->lastItem() }}</span>
                de <span class="font-semibold text-white">{{ $paginator->total() }}</span> resultados
            @endif
        </p>

        <div class="flex flex-wrap items-center gap-1">
            @php($base = 'grid place-items-center min-w-9 h-9 px-3 rounded-lg text-sm font-medium transition')

            @if ($paginator->onFirstPage())
                <span class="{{ $base }} text-slate-500 cursor-not-allowed" aria-disabled="true">&lsaquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $base }} text-slate-200 bg-navy-900 ring-1 ring-white/10 hover:bg-navy-800" aria-label="Anterior">&lsaquo;</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="{{ $base }} text-slate-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="{{ $base }} bg-brand-500 text-white" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="{{ $base }} text-slate-200 bg-navy-900 ring-1 ring-white/10 hover:bg-navy-800">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $base }} text-slate-200 bg-navy-900 ring-1 ring-white/10 hover:bg-navy-800" aria-label="Próxima">&rsaquo;</a>
            @else
                <span class="{{ $base }} text-slate-500 cursor-not-allowed" aria-disabled="true">&rsaquo;</span>
            @endif
        </div>
    </nav>
@endif
