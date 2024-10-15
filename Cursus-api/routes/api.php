<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreatureController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MailTesterController;

//
// REGISTER
//
Route::post('/register', [RegisterController::class, 'register'])->name('register');

//
// FORGOT PASSWORD
//
Route::post('/password-email', [ForgotPasswordController::class, 'email'])->name('password.email');
Route::post('/password-reset', [ForgotPasswordController::class, 'reset'])->name('password.reset');

//
// MAIL
//
Route::get('/mail-test', [MailTesterController::class, 'sendMail'])->name('mail.test');
Route::get('/perf', [CreatureController::class, 'perfTest']);

//
// USERS
//
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [UserController::class, 'me'])->name('users.me');
    Route::get('/users', [UserController::class, 'index'])->name('users.list');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');    
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

//
// CREATURES
//

Route::get('/creatures/{id}/weapons', [CreatureController::class, 'getWeapons'])->name('creatures.getWeapons');

Route::get('/creatures', [CreatureController::class, 'index'])->name('creatures.list');
Route::get('/creatures-paginate', [CreatureController::class, 'paginate'])->name('creatures.paginate');
Route::get('/creatures/{creature}', [CreatureController::class, 'show'])->name('creatures.show');
Route::get('/creatures-by-user/{user}', [CreatureController::class, 'indexByUser'])->name('creatures.listByUser');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/creatures', [CreatureController::class, 'store'])->name('creatures.store');
    Route::put('/creatures/{creature}', [CreatureController::class, 'update'])->name('creatures.update');
    Route::delete('/creatures/{creature}', [CreatureController::class, 'destroy'])->name('creatures.destroy');    
});