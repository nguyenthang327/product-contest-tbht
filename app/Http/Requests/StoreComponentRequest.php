<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComponentRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:components,code,' . $this->route('id'),
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'price' => 'nullable|numeric',
            'measure' => 'nullable|string|max:255',
        ];
    }
}
