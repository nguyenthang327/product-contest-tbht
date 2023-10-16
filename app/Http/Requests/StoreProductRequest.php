<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $rules = [
            'code' => 'required|string|max:255|unique:products,code,' . $this->route('id'),
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'type' => 'required|in:1,2', // loại sản phẩm
        ];

        if(empty($this->type) || $this->type != 2){
            $rules['parent_id'] = 'nullable';
        }else{
            $rules['parent_id'] = 'required|exists:products,id';
        }

        return $rules;
    }
}
