<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreatureController;
use App\Http\Controllers\CreatureWeaponController;
use App\Http\Controllers\UserCreatureController;
use App\Http\Controllers\MailTesterController;
use App\Http\Controllers\AuthController;

//
// LOGIN
//
Route::middleware(['web', 'throttle:login'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout']); // à checker pour passer en post
});

//
// PUBLIC ROUTES
//
Route::middleware(['throttle:api'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verification', [AuthController::class, 'verification']);
    Route::get('/mail-test', [MailTesterController::class, 'sendMail']);

    Route::controller(AuthController::class)->prefix('forgot-password')->group(function () {
        Route::post('/email', 'forgotPasswordEmail');
        Route::post('/reset', 'forgotPasswordReset');
    });

    Route::controller(CreatureController::class)->prefix('creatures')->group(function () {
        Route::get('/', 'index');
        Route::get('/search', 'search');
        Route::get('/races', 'getRaces');
        Route::get('/types', 'getTypes');
        Route::get('/{creature}', 'show');
    });

    Route::controller(CreatureWeaponController::class)->prefix('creatures/{creature}/weapons')->group(function () {
        Route::get('/', 'index');
    });

    Route::controller(UserCreatureController::class)->prefix('users/{user}/creatures')->group(function () {
        Route::get('/', 'index');
    });
});

//
// LOGGED ROUTES
//
Route::middleware(['throttle:api', 'auth:sanctum'])->group(function () {
    Route::controller(CreatureController::class)->prefix('creatures')->group(function () {
        Route::post('/', 'store');
        Route::put('/{creature}', 'update');
        Route::delete('/{creature}', 'destroy');        
    });

    Route::get('/user', [AuthController::class, 'user']);
});