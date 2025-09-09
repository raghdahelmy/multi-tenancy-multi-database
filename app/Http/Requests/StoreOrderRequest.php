<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // ممكن نسيب total فاضي وهنحسبه من العناصر
            'status' => ['nullable','in:pending,paid,cancelled,shipped,completed'],

            'items'               => ['required','array','min:1'],
            'items.*.product_id'  => ['required','exists:products,id'],
            'items.*.quantity'    => ['required','integer','min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'لازم تبعتي عناصر الطلب (items).',
            'items.*.product_id.required' => 'كل عنصر لازم يكون له product_id.',
        ];
    }
};