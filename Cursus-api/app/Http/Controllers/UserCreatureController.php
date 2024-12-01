<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserCreatureController extends Controller
{
    public function index(User $user)
    {
        return response()->json($user->creatures);
    }
}