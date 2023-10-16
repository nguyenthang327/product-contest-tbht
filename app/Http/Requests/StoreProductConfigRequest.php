<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductConfigRequest extends FormRequest
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
        return [
            'product_id' => 'required|exists:products,id',
            'code' => 'required|string|max:255|unique:product_configs,code,' . $this->route('id'),
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'specification_ids' => 'nullable|array',
            'specification_ids.*' => 'nullable|exists:specifications,id',
        ];
    }
}
