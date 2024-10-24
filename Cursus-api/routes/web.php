<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate')->middleware(['verified']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');