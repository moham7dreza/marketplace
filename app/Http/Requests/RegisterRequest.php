<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:1120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), 'confirmed'],
        ];
    }
}
