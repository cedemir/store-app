@php($user = $user ?? null)

<div class="card p-6 max-w-3xl">
    <x-admin.input name="name" label="Nome" :value="$user?->name" required />
    <x-admin.input name="email" label="E-mail" type="email" :value="$user?->email" required />
    <x-admin.select name="role" label="Perfil" :options="['ROLE_CUSTOMER' => 'Cliente', 'ROLE_ADMIN' => 'Administrador']"
        :value="$user?->role ?? 'ROLE_CUSTOMER'" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
        <x-admin.input name="password" label="Senha" type="password" autocomplete="new-password"
            :hint="$user ? 'Deixe em branco para manter a senha atual.' : 'Mínimo de 8 caracteres.'" />
        <x-admin.input name="password_confirmation" label="Confirmar Senha" type="password" autocomplete="new-password" />
    </div>

    <button class="btn btn-primary">{{ $submit }}</button>
</div>
