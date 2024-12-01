<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
use Illuminate\Validation\Rules\Enum;

class CreatureStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'pv' => 'required|numeric|min:0',
            'atk' => 'required|numeric|min:0',
            'def' => 'required|numeric|min:0',
            'speed' => 'required|numeric|min:0',
            'capture_rate' => 'required|numeric|min:0',
            'type' => ['required', new Enum(CreatureTypeEnum::class)],
            'race' => ['required', new Enum(CreatureRaceEnum::class)],
            'avatar' => 'mimes:jpg,jpeg,png|max:15360',
            'user_id' => 'required|numeric'
        ];
    }
}
