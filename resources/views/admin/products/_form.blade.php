@php
    $product = $product ?? null;
    $selectedCategories = collect(old('categories', $product?->categories->pluck('id')->all() ?? []))->map(fn($id) => (int) $id);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card p-6 lg:col-span-2">
        <x-admin.input name="name" label="Nome" :value="$product?->name" required />
        <x-admin.input name="description" label="Descrição curta" :value="$product?->description" hint="Mínimo de 20 caracteres." />
        <x-admin.textarea name="body" label="Conteúdo" :value="$product?->body" rows="10" />
        <x-admin.input name="slug" label="Slug" :value="$product?->slug" hint="Usado na URL da loja. Deixe em branco para gerar a partir do nome." />
    </div>

    <div class="space-y-6">
        <div class="card p-6">
            <x-admin.input name="price" label="Preço (R$)" placeholder="0,00" inputmode="decimal"
                :value="$product ? number_format($product->price, 2, ',', '.') : null" />
            <x-admin.input name="in_stock" label="Estoque" type="number" min="0" :value="$product?->in_stock" />
            <x-admin.select name="is_active" label="Status" :options="['1' => 'Ativo', '0' => 'Inativo']"
                :value="$product ? (int) $product->is_active : 1" />
        </div>

        <div class="card p-6">
            <p class="mb-2 text-sm font-medium @error('categories') text-red-400 @else text-white @enderror">Categorias</p>
            <div class="space-y-1 max-h-64 overflow-y-auto">
                @forelse($categories as $category)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="accent-brand-500"
                            @checked($selectedCategories->contains($category->id))>
                        {{ $category->name }}
                    </label>
                @empty
                    <p class="text-sm text-slate-300">
                        Nenhuma categoria cadastrada. <a href="{{ route('categories.create') }}" class="text-brand-300 underline">Criar categoria</a>
                    </p>
                @endforelse
            </div>
            @error('categories')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
            @error('categories.*')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button class="w-full btn btn-primary">{{ $submit }}</button>
    </div>
</div>
