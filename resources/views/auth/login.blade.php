<x-layouts.auth title="Entrar na sua conta" subtitle="Bem-vindo de volta! Informe seus dados de acesso.">
    <form action="{{ route('login') }}" method="post" novalidate class="space-y-5">
        @csrf

        <div>
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="voce@email.com"
                autocomplete="email" autofocus required @class(['form-input', 'form-input-error' => $errors->has('email')])>
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" placeholder="••••••••" autocomplete="current-password"
                @class(['form-input', 'form-input-error' => $errors->has('password')])>
            @error('password') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <label for="rememberme" class="flex items-center gap-2 text-sm text-slate-200">
            <input type="checkbox" name="rememberme" id="rememberme" class="size-4 rounded accent-brand-500">
            Lembrar de mim
        </label>

        <button class="btn btn-primary btn-lg w-full">Entrar</button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-300">
        Ainda não tem conta?
        <a href="{{ route('register.index') }}" class="font-semibold text-brand-300 hover:text-brand-200">Criar conta</a>
    </p>
</x-layouts.auth>
