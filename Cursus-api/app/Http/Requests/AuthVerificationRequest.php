<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthVerificationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|string|email|exists:users',
            'token' => 'required|string|min:40|exists:users'
        ];
    }
}