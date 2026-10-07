<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name'     => 'required|min:3',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => [$user ? 'nullable' : 'required', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['ROLE_ADMIN', 'ROLE_CUSTOMER'])],
        ];
    }

    public function messages()
    {
        return [
            'required'  => 'Este campo é obrigatório',
            'min'       => 'Este campo deve ter pelo menos :min caracteres',
            'email'     => 'Informe um e-mail válido',
            'unique'    => 'Este e-mail já está em uso',
            'confirmed' => 'A confirmação de senha não confere',
            'in'        => 'Valor inválido',
        ];
    }
}
