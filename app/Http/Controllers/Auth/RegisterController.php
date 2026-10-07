<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct(private User $userModel)
    {

    }
    public function index()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, CartService $cart)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = $this->userModel->create($data);

        event(new Registered($user));

        auth()->login($user);

        if($cart->count()) {
            return redirect()->route('site.checkout.index');
        }

        return redirect()->route('site.home');
    }
}
