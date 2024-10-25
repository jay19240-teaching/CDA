<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
use Illuminate\Validation\Rules\Enum;

class CreatureRequest extends FormRequest
{
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name' => 'Le nom est incorrect',
            'pv' => 'Les point de vie sont incorrect',
            'atk' => 'L\'attaque est incorrect',
            'def' => 'La defense est incorrect',
            'speed' => 'La vitesse est incorrect',
            'capture_rate' => 'Le taux de capture est incorrect',
            'type' => 'Le type est incorrect',
            'race' => 'La race est incorrect',
            'avatar' => 'L\'avatar est incorrect'
        ];
    }
}
