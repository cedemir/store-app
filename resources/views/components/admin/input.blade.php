@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null])

<div class="w-full mb-5">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        @if($type !== 'password') value="{{ old($name, $value) }}" @endif
        {{ $attributes->class(['form-input', 'form-input-error' => $errors->has($name)]) }}>

    @if($hint)
        <p class="mt-1.5 text-xs text-slate-300">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
