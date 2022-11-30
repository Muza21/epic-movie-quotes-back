<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username'           => 'required|unique:users,username|min:3|max:255',
            'email'              => 'required|unique:users,email|email|min:3|max:255',
            'password'           => 'required|confirmed|min:7|max:255',
        ];
    }
}
