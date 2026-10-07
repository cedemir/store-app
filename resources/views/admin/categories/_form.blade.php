@php($category = $category ?? null)

<div class="card p-6 max-w-3xl">
    <x-admin.input name="name" label="Nome" :value="$category?->name" required />
    <x-admin.input name="description" label="Descrição" :value="$category?->description" hint="Opcional. Mínimo de 20 caracteres." />
    <x-admin.input name="slug" label="Slug" :value="$category?->slug" hint="Deixe em branco para gerar a partir do nome." />

    <button class="btn btn-primary">{{ $submit }}</button>
</div>
