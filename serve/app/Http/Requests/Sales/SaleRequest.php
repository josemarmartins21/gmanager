<?php

namespace App\Http\Requests\Sales;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'note' => 'nullable|string|max:255|min:10',
            'total_payed' => 'required|numeric|gte:0|decimal:0,2',
        ];
    }

    public function attributes()
    {
        return [
            'total_payed' => 'total pago',
            'note' => 'nota'
        ];
    }
}
