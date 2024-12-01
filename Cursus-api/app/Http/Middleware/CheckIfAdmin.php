<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;

class CheckIfAdmin
{
    private function checkIfUserIsAdmin($user)
    {
        return $user->role == RoleEnum::ROLE_ADMIN;
    }

    private function respondToUnauthorizedRequest($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 401);
        } else {
            return redirect()->guest(backpack_url('login'));
        }
    }

    public function handle($request, Closure $next)
    {
        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        if (! $this->checkIfUserIsAdmin(backpack_user())) {
            return $this->respondToUnauthorizedRequest($request);
        }

        return $next($request);
    }
}