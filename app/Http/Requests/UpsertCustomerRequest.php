<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [Rule::requiredIf($this->method === 'POST'), 'max:255'],
            'last_name' => [Rule::requiredIf($this->method === 'POST'), 'max:255'],
            'email' => [Rule::requiredIf($this->method === 'POST'), 'email', 'max:255'],
            'contact_number' => [Rule::requiredIf($this->method === 'POST'), 'max:255']
        ];
    }
}
