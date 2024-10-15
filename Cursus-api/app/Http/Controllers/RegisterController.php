<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::defaults()]
        ]);

        $userFound = DB::table('users')->where('email', $formFields['email']);
        if ($userFound->count() > 0) {
            return response()->json(['errors' => 'User already exist'], 400);
        }

        $user = new User();
        $user->fill($formFields);
        $user->email_verified_at = now();
        $user->save();
        return response()->json($user);
    }
}