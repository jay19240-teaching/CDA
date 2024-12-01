<?php

namespace App\Http\Controllers;

use App\Models\Creature;

class CreatureWeaponController extends Controller
{
    public function index(Creature $creature)
    {
        return response()->json($creature->weapons);
    }
}