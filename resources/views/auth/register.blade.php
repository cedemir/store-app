<x-layouts.auth title="Criar sua conta" subtitle="Leva menos de um minuto.">
    <form action="{{ route('register.store') }}" method="post" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="form-label">Nome completo</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Seu nome" autocomplete="name" required
                @class(['form-input', 'form-input-error' => $errors->has('name')])>
            @error('name') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="voce@email.com" autocomplete="email" required
                @class(['form-input', 'form-input-error' => $errors->has('email')])>
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" placeholder="Mínimo de 8 caracteres" autocomplete="new-password"
                @class(['form-input', 'form-input-error' => $errors->has('password')])>
            @error('password') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Confirmar senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a senha" autocomplete="new-password"
                class="form-input">
        </div>

        <button class="btn btn-primary btn-lg w-full">Criar conta</button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-300">
        Já tem uma conta?
        <a href="{{ route('login.view') }}" class="font-semibold text-brand-300 hover:text-brand-200">Entrar</a>
    </p>
</x-layouts.auth>
