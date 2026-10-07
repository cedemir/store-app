<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, (bool) $request->rememberme)) {
            throw ValidationException::withMessages([
                'email' => 'Acesso Inválido...',
            ]);
        }

        $request->session()->regenerate();

        $home = $request->user()->hasRole('ROLE_ADMIN') ? 'admin.dashboard' : 'site.home';

        return redirect()->intended(route($home, absolute: false));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
