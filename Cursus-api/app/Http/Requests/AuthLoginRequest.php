<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|min:4',
            'password' => 'required'
        ];
    }
}