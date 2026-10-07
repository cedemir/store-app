@php($user = $user ?? null)

<div class="w-full mb-6">
    <label class="block mb-2 @error('name') text-red-900 @enderror">Nome</label>
    <input type="text" name="name" class="w-full p-2 rounded border @error('name') border-red-900 @else border-gray-900 @enderror"
        value="{{ old('name', $user?->name) }}">

    @error('name')
        <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
    @enderror
</div>

<div class="w-full mb-6">
    <label class="block mb-2 @error('email') text-red-900 @enderror">E-mail</label>
    <input type="email" name="email" class="w-full p-2 rounded border @error('email') border-red-900 @else border-gray-900 @enderror"
        value="{{ old('email', $user?->email) }}">

    @error('email')
        <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
    @enderror
</div>

<div class="w-full mb-6">
    <label class="block mb-2 @error('role') text-red-900 @enderror">Perfil</label>
    <select name="role" class="w-full p-2 rounded border @error('role') border-red-900 @else border-gray-900 @enderror">
        @foreach(['ROLE_CUSTOMER' => 'Cliente', 'ROLE_ADMIN' => 'Administrador'] as $value => $label)
            <option value="{{ $value }}" @selected(old('role', $user?->role ?? 'ROLE_CUSTOMER') === $value)>{{ $label }}</option>
        @endforeach
    </select>

    @error('role')
        <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
    @enderror
</div>

<div class="w-full mb-6">
    <label class="block mb-2 @error('password') text-red-900 @enderror">
        Senha @if($user)<span class="font-thin text-sm">(deixe em branco para manter a atual)</span>@endif
    </label>
    <input type="password" name="password" autocomplete="new-password"
        class="w-full p-2 rounded border @error('password') border-red-900 @else border-gray-900 @enderror">

    @error('password')
        <div class="w-full mt-2 p-2 rounded border border-red-900 bg-red-400 text-red-900">{{$message}}</div>
    @enderror
</div>

<div class="w-full mb-6">
    <label class="block mb-2">Confirmar Senha</label>
    <input type="password" name="password_confirmation" autocomplete="new-password"
        class="w-full p-2 rounded border border-gray-900">
</div>
