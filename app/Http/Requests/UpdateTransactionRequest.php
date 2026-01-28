<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
            'category_id' => 'sometimes|required|exists:categories,category_id',
                'amount' => 'sometimes|required|numeric|min:0',
                'type' => 'sometimes|required|in:income,expense',
                'description' => 'nullable|string',
                'transaction_date' => 'sometimes|required|date'
        ];
    }

    public function messages()
    {
        return [
            'category_id.required'=>'category name is required',
            'amount.required'=>'Amount is required',
            'type.required'=>'category type is required',
            'type.in'=>'category type must be either income or expense',
            'transaction_date.required'=>'Transaction date must be provided'
        ];
    }
}
