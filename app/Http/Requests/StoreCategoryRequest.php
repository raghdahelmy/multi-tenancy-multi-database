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

    /**
     * Get the validation rules that apply to the request.
     *
     */
     public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
        ];
    }

    /**
     * Optional: Custom messages for validation errors
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'This category already exists',
        ];
    }
    
}
