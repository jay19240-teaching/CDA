<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatureDestroyRequest extends FormRequest
{
    public function authorize()
    {
        $creature = $this->route('creature');

        if (Auth::user()->role == RoleEnum::ROLE_ADMIN)
        {
            return true;
        }

        if ($creature->user_id == Auth::id())
        {
            return true;
        }

        return false;
    }
}