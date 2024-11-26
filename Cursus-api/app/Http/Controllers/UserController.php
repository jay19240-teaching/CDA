<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

use App\Http\Requests\UserStore;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(UserStore $request)
    {
        $formFields = $request->validated();

        $user = new User();
        $user->fill($formFields);
        $user->token = Str::random(40);
        $user->save();

        return response()->json($formFields);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $formFields = $request->validate([
            'name' => 'string',
            'role' => [new Enum(RoleEnum::class)],
            'email' => ['string', 'email', 'max:255', Rule::unique('users', 'email')],
        ]);

        $user->fill($formFields);
        $user->save();

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        return response()->json(['success' => 'success']);
    }
}