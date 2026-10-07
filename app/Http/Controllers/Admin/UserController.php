<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private User $user) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->user
            ->withCount('orders')
            ->when($request->q, fn($query, $q) => $query->where(
                fn($query) => $query->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%")
            ))
            ->when($request->status, fn($query, $role) => $query->where('role', $role))
            ->orderBy('id', 'DESC')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        // role fica fora do $fillable para não ser atribuído pelo cadastro público
        $user = $this->user->newInstance($data);
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('users.edit', ['user' => $user->id])
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return redirect()->route('users.edit', ['user' => $user->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) unset($data['password']);

        if ($user->is(auth()->user()) && $data['role'] !== $user->role) {
            return redirect()->back()->with('error', 'Você não pode alterar o seu próprio perfil de acesso.');
        }

        $user->fill($data);
        $user->role = $data['role'];
        $user->save();

        return redirect()->route('users.edit', ['user' => $user->id])
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return redirect()->back()->with('error', 'Você não pode remover o seu próprio usuário.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');
    }
}
