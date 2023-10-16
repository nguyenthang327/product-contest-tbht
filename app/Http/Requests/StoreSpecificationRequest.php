<?php

namespace App\Http\Requests;

use App\Enums\SpecificationGroupEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreSpecificationRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:specifications,code,' . $this->route('id'),
            'name' => 'required|string|max:255',
            'specification_group_id' => 'required|in:'. SpecificationGroupEnum::CPU->value . ',' . SpecificationGroupEnum::RAM->value . ','. SpecificationGroupEnum::HARD_DRIVE->value . ','. SpecificationGroupEnum::COLOR->value . ','. SpecificationGroupEnum::BATTERY->value,
            'component' => 'nullable|array',
            'component.id' => 'nullable|array',
            'component.id.*' => 'nullable|exists:components,id',
        ];
    }
}
