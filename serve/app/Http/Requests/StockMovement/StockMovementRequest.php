<?php

namespace App\Http\Requests\StockMovement;

use App\Enums\StockOperations;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockMovementRequest extends FormRequest
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
        $allowedOperations = StockOperations::cases();

        return [
            'type' => 'required|string|'. Rule::in($allowedOperations),
            'box_qty' => 'nullable|integer|min:1|max:100',
            'units_per_box' => 'required_with:box_qty|nullable|integer|min:2|max:150',
            'box_price' => 'required_with:box_qty|nullable|decimal:0,2|gte:800',
            'total_units' => 'required_without:box_qty|nullable|integer|min:1|max:100',
            'note' => 'required|string|max:300',
            'product_id' => 'required|integer|min:1|exists:products,id',
        ];
    }

    public function attributes()
    {
        return [
            'box_price' => 'preço da caixa/grade',
            'total_units' => 'total de unidades',
            'note' => 'anotação',
            'box_qty' => 'número de caixa/grade',
            'units_per_box' => 'número de unidades por caixa/grade',
            'type' => 'tipo de operação',
            'product_id' => 'producto',
        ];
    }
}
