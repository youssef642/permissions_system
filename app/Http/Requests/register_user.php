<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class register_user extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => [
                'required',
                'regex:/^01[0125][0-9]{8}$/'
            ],
            'role' => 'required|in:user,admin,manager',
        ];
    }
}
