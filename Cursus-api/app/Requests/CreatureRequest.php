<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pseudo'   => 'required|string|alpha_dash|min:3|max:25|unique:users,pseudo',
            'email'    => 'required|string|email|max:100|unique:users,email',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' =>
            [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------|
            |   Messages PSEUDO                                                         |
            |--------------------------------------------------------------------------|
            */
            'pseudo.required'   => 'Le pseudo est obligatoire.',
            'pseudo.string'     => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.alpha_dash' => 'Le pseudo peut contenir uniquement des lettres, des chiffres, des tirets et des underscores.',
            'pseudo.min'        => 'Le pseudo doit comporter au moins 3 caractères.',
            'pseudo.max'        => 'Le pseudo ne peut pas dépasser 25 caractères.',
            'pseudo.unique'     => 'Ce pseudo est déjà utilisé.',

            /*
            |--------------------------------------------------------------------------|
            |   Messages EMAIL                                                          |
            |--------------------------------------------------------------------------|
            */
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.string'   => 'L\'adresse email doit être une chaîne de caractères.',
            'email.email'    => 'Veuillez entrer une adresse email valide.',
            'email.max'      => 'L\'adresse email ne peut pas dépasser 100 caractères.',
            'email.unique'   => 'Cette adresse email est déjà utilisée.',

            /*
            |--------------------------------------------------------------------------|
            |   Messages PASSWORD                                                       |
            |--------------------------------------------------------------------------|
            */
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.string'    => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min'       => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

            /*
            |--------------------------------------------------------------------------|
            |   Messages IMAGE                                                          |
            |--------------------------------------------------------------------------|
            */
            'image.image'  => 'Le fichier doit être une image.',
            'image.mimes'  => 'L\'image doit être au format jpeg, png, jpg, gif ou svg.',
            'image.max'    => 'L\'image ne peut pas dépasser 2 Mo.',
        ];
    }
}
