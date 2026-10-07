<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normaliza preço (formato 1.234,56) e gera o slug a partir do nome quando vazio.
     */
    protected function prepareForValidation(): void
    {
        $price = (string) $this->input('price', '');

        if (str_contains($price, ',')) {
            $price = str_replace(['.', ','], ['', '.'], $price);
        }

        $this->merge([
            'price' => $price,
            'slug'  => Str::slug($this->input('slug') ?: $this->input('name', '')),
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
            'name'         => 'required|max:255',
            'description'  => 'required|min:20|max:255',
            'body'         => 'required',
            'price'        => 'required|numeric|min:0',
            'in_stock'     => 'required|integer|min:0',
            'is_active'    => 'required|boolean',
            'slug'         => ['required', 'max:255', Rule::unique('products', 'slug')->ignore($this->route('product'))],
            'categories'   => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'required'        => 'Este campo é obrigatório',
            'min'             => 'Este campo deve ser no mínimo :min',
            'description.min' => 'A descrição deve ter pelo menos :min caracteres',
            'max'             => 'Este campo deve ter no máximo :max caracteres',
            'numeric'         => 'Informe um valor numérico (ex.: 1.234,56)',
            'integer'         => 'Informe um número inteiro',
            'unique'          => 'Já existe um produto com este slug',
            'categories.required' => 'Selecione pelo menos uma categoria',
            'exists'          => 'Categoria inválida',
        ];
    }
}
