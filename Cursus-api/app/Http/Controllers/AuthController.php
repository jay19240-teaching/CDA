<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthForgotPasswordEmailRequest;
use App\Http\Requests\AuthForgotPasswordResetRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthVerificationRequest;
use App\Mail\RegisterEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->has('remember-me');

        if (!Auth::attempt($credentials, $remember))
        {
            return response()->json(['user' => null], 401);
        }

        if (!Auth::user()->email_verified_at)
        {
            return response()->json(['user' => null], 401);
        }

        $request->session()->regenerate();
        return response()->json(['user' => Auth::user()]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['success' => true]);
    }

    public function register(AuthRegisterRequest $request)
    {
        $formFields = $request->validated();
        $user = new User();
        $user->fill($formFields);
        $user->token = Str::random(40);
        $user->save();

        Mail::to($user->email)->send(new RegisterEmail($user));
        return response()->json(['success' => true]);
    }

    public function verification(AuthVerificationRequest $request)
    {
        $formFields = $request->validated();
        $user = User::where('email', '=', $formFields['email'])
            ->where('token', '=', $formFields['token'])
            ->where('email_verified_at', '=', null)
            ->first();

        if (!$user)
        {
            return response()->json(['failed' => true, 400]);
        }

        $user->email_verified_at = now();
        $user->save();
        return response()->json(['success' => true]);
    }

    public function forgotPasswordEmail(AuthForgotPasswordEmailRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status !== Password::PASSWORD_RESET)
        {
            return response()->json(['failed' => true], 500);
        }

        return response()->json(['success' => true]);        
    }

    public function forgotPasswordReset(AuthForgotPasswordResetRequest $request) {
        $credentials = $request->validated();
        $status = Password::reset($credentials, function (User $user, string $password) {
            $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET)
        {
            return response()->json(['failed' => true], 500);
        }

        return response()->json(['success' => true]);        
    }
}