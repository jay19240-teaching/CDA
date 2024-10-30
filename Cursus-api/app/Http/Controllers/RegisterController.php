<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()]
        ]);

        $user = new User();
        $user->fill($formFields);
        $user->token = Str::random(40);
        $user->save();

        Mail::to($user->email)->send(new RegisterEmail($user));
        return response()->json(['success' => 'success']);
    }

    public function verification(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required|string|email|exists:users',
            'token' => 'required|string|min:40|exists:users'
        ]);

        $user = User::where('email', '=', $formFields['email'])
            ->where('token', '=', $formFields['token'])
            ->where('email_verified_at', '=', null)
            ->first();

        if (!$user)
        {
            return response()->json(['failed' => 'failed', 400]);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['success' => 'success']);
    }
}