<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreatureUpdateRequest extends FormRequest
{
    public function authorize()
    {
        $creature = $this->route('creature');

        if (Auth::user()->role == RoleEnum::ROLE_ADMIN->value)
        {
            return true;
        }

        if ($creature->user_id == Auth::id())
        {
            return true;
        }
        
        return false;
    }

    public function rules()
    {
        return [
            'name' => 'string',
            'pv' => 'numeric|between:1,100',
            'atk' => 'numeric|between:1,100',
            'def' => 'numeric|between:1,100',
            'speed' => 'numeric|between:1,100',
            'type' => [new Enum(CreatureTypeEnum::class)],
            'race' => [new Enum(CreatureRaceEnum::class)],
            'capture_rate' => 'numeric|between:1,100',
            'avatar_blob' => 'mimes:png,jpg,jpeg,pdf,docx|max:2048'
        ];
    }
}