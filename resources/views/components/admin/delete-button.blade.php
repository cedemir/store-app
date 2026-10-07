@props(['action', 'label' => 'Remover', 'confirm' => 'Deseja realmente remover este registro?'])

<form action="{{ $action }}" method="post" onsubmit="return confirm(@js($confirm))" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" @if(!$label) aria-label="Remover" title="Remover" @endif
        {{ $attributes->merge(['class' => 'btn btn-sm bg-navy-900 text-red-400 ring-1 ring-red-500/40 hover:bg-red-500/15 hover:ring-red-400/60']) }}>
        <x-admin.icon name="trash" class="size-4" />
        {{ $label }}
    </button>
</form>
