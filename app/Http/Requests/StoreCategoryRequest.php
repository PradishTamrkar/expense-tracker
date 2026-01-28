<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'=>'required|string|max:255',
            'type'=>'required|in:income,expense',
            'icon'=>'nullable|string',
            'color'=>'nullable|string|max:7',
            'description'=>'nullable|string'
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
