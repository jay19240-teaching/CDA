![image](imgs/api-base-cover.png)
## Réinitialisation du mot de passe
**Document de référence:** https://laravel.com/docs/11.x/passwords  
Soumission de la demande de mot de passe oublié:
```php
public function email(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
}
```

Soumission de la réinitialisation:
```php
public function reset(Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

    $status = Password::reset($credentials, function (User $user, string $password) {
        $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
        $user->save();
        event(new PasswordReset($user));
    });

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
}
```

Pour customiser l'e-mail du mot de passe oublié:
```php
use Illuminate\Auth\Notifications\ResetPassword;
ResetPassword::toMailUsing(function (User $user, string $token) {
    return Mail::to($user->email)->send(new RecoveryPasswordEmail($token));
})
```

Les routes:
```php
Route::post('/password-email', [ForgotPasswordController::class, 'email'])->name('password.email');
Route::post('/password-reset', [ForgotPasswordController::class, 'reset'])->name('password.reset');
```