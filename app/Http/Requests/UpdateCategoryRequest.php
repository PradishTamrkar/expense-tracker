<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:income,expense',
            'icon' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'category name is required',
            'type.required'=>'category type is required',
            'type.in'=>'category type must be either income or expense'
        ];
    }
}
