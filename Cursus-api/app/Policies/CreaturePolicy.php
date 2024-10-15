<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Creature;

class CreaturePolicy
{
    public function __construct()
    {}

    public function update(?User $user, Creature $creatureTarget)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id == $creatureTarget->user_id;
    }

    public function destroy(?User $user, Creature $creatureTarget)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id == $creatureTarget->user_id;
    }
}