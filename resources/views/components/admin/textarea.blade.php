@props(['name', 'label', 'value' => null, 'rows' => 6])

<div class="w-full mb-5">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
        {{ $attributes->class(['form-input', 'form-input-error' => $errors->has($name)]) }}>{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
