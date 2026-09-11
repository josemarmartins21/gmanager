<?php

namespace App\Http\Requests\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'gte:20', 'decimal:0,2'],
            'box_price' => ['required', 'numeric', 'gte:500', 'decimal:0,2'],
            'min_stock' => ['nullable', 'integer', 'min:3', 'max:10', 'numeric'],
            'category_id' => ['required', 'exists:categories,id','numeric', 'integer', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.integer' => 'Foi enviada uma :attribute inválida',
            'category_id.min' => 'Foi enviada uma :attribute inválida',
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => 'categoria',
            'name' => 'nome',
            'price' => 'preço',
            'box_price' => 'preço da grade',
            'min_stock' => 'estoque mínimo',
        ];
    }
}
