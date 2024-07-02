<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ListCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable'],
            'sort' => ['nullable', 'array', 'required_array_keys:field'],
            'sort.field' => [Rule::in(Schema::getColumnListing('customers'))],
            'sort.order' => ['nullable', 'in:asc,desc']
        ];
    }

    public function messages(): array
    {
        return [
          'sort.order.in' => 'Sort order must be `asc` or `desc`.'
        ];
    }
}
