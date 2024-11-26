<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreatureController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MailTesterController;
use App\Http\Controllers\AuthController;

//
// LOGIN
//
Route::middleware(['web', 'throttle:login'])->group(function () {
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

//
// PUBLIC ROUTES
//
Route::middleware(['throttle:api'])->group(function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/verification', [RegisterController::class, 'verification']);
    Route::get('/mail-test', [MailTesterController::class, 'sendMail']);
    Route::get('/perf', [CreatureController::class, 'perfTest']);

    Route::controller(ForgotPasswordController::class)->prefix('password')->group(function () {
        Route::post('-email', 'email');
        Route::post('-reset', 'reset');
    });

    Route::controller(CreatureController::class)->prefix('creatures')->group(function () {
        Route::get('/{id}/weapons', 'getWeapons');
        Route::get('/', 'index');
        Route::get('/{creature}', 'show');
        Route::get('-by-user/{user}', 'listByUser');
        Route::get('-paginate', 'paginate');
        Route::get('-races', 'getRaces');
        Route::get('-types', 'getTypes');
    });
});

//
// LOGGED ROUTES
//
Route::middleware(['throttle:api', 'auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'user']);

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{user}', 'show');    
        Route::put('/{user}', 'update');
        Route::delete('/{user}', 'destroy');
    });

    Route::controller(CreatureController::class)->prefix('creatures')->group(function () {
        Route::post('/', 'store');
        Route::put('/{creature}', 'update');
        Route::delete('/{creature}', 'destroy');        
    });
});