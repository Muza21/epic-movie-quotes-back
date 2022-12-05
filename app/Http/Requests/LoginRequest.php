<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'min:3', Rule::exists('users', filter_var($this->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username')],
            'password' => 'required|min:3',
            'remember' => 'sometimes|nullable',
        ];
    }
}
