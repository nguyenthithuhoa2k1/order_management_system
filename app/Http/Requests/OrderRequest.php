<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date_order' => 'required',
            'product_id' => 'required',
            'customer_id' => 'required',
            'quantity' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute không được trống',
            'numeric' => ':attribute không phải số.'
        ];
    }
}
