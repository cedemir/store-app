<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Gera o slug a partir do nome quando não for informado.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name', '')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|max:255',
            'description' => 'nullable|min:20|max:255',
            'slug'        => ['required', 'max:255', Rule::unique('categories', 'slug')->ignore($this->route('category'))],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Este campo é obrigatório',
            'min'      => 'Este campo deve ter pelo menos :min caracteres',
            'max'      => 'Este campo deve ter no máximo :max caracteres',
            'unique'   => 'Já existe uma categoria com este slug',
        ];
    }
}
