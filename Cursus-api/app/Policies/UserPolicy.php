<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function __construct()
    {}

    public function store(?User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function update(?User $user, User $userTarget)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id == $userTarget->id;
    }

    public function destroy(?User $user, User $userTarget)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id == $userTarget->id;
    }
}