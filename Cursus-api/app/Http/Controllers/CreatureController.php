<?php

namespace App\Http\Controllers;

use App\Models\Creature;
use App\Models\User;
use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class CreatureController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return response()->json(Creature::all());
    }

    public function indexByUser(User $user = null)
    {
        $creatures = DB::table('creatures')->where('user_id', '=', $user->id)->get();
        return response()->json($creatures);
    }

    public function getWeapons(Request $request, string $id)
    {
        $creature = Creature::find($id);
        return response()->json($creature->weapons);
    }

    public function getTypes()
    {
        return response()->json(CreatureTypeEnum::values());
    }

    public function getRaces()
    {
        return response()->json(CreatureRaceEnum::values());
    }

    public function paginate(Request $request)
    {
        $page = $request->query('page', 1);
        $name = $request->query('name');
        $minPv = $request->query('minPv');
        $maxPv = $request->query('maxPv');
        $types = $request->query('types');
        $races = $request->query('races');
        $orderBy = $request->query('orderBy');
        $orderType = $request->query('orderType');
        $limit = $request->query('limit', 3);

        $results = Creature::search(
            name: $name,
            minPv: $minPv,
            maxPv: $maxPv,
            types: $types,
            races: $races,
            page: $page,
            limit: $limit,
            orderBy: $orderBy,
            orderType: $orderType
        );

        $maxPages = ceil($results['totalResults'] / $limit);

        return response()->json([
            'creatures' => $results['creatures'],
            'maxPages' => $maxPages,
            'page' => $page
        ]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string',
            'pv' => 'required|numeric|between:1,100',
            'atk' => 'required|numeric|between:1,100',
            'def' => 'required|numeric|between:1,100',
            'speed' => 'required|numeric|between:1,100',
            'type' => ['required', new Enum(CreatureTypeEnum::class)],
            'race' => ['required', new Enum(CreatureRaceEnum::class)],
            'avatar_blob' => 'mimes:jpg,jpeg,png|max:15360',
            'capture_rate' => 'required|numeric|between:1,100'
        ]);

        $creature = new Creature();
        $creature->user_id = Auth::user()->id;
        $creature->fill($formFields);
        
        if ($request->file('avatar_blob')) {
            $fileName = time() . '_' . $request->avatar_blob->getClientOriginalName();
            $creature->avatar = $fileName;
            $request->avatar_blob->move(public_path('images/uploads'), $fileName);
        }

        $creature->save();
        return response()->json($creature);
    }

    public function show(string $id)
    {
        $creature = Creature::with('user')->find($id);
        return response()->json($creature);
    }

    public function update(Request $request, Creature $creature)
    {
        $this->authorize('update', $creature);

        $formFields = $request->validate([
            'name' => 'string',
            'pv' => 'numeric|between:1,100',
            'atk' => 'numeric|between:1,100',
            'def' => 'numeric|between:1,100',
            'speed' => 'numeric|between:1,100',
            'type' => [new Enum(CreatureTypeEnum::class)],
            'race' => [new Enum(CreatureRaceEnum::class)],
            'capture_rate' => 'numeric|between:1,100',
            'avatar_blob' => 'mimes:png,jpg,jpeg,pdf,docx|max:2048'
        ]);

        $creature->fill($formFields);

        if ($request->file('avatar_blob') && File::exists(public_path('images/uploads/' . $creature->avatar))) {
            File::delete(public_path('images/uploads/' . $creature->avatar));
        }

        if ($request->file('avatar_blob')) {
            $fileName = time() . '_' . $request->avatar_blob->getClientOriginalName();
            $creature->avatar = $fileName;
            $request->avatar_blob->move(public_path('images/uploads'), $fileName);
        }

        $creature->save();
        return response()->json($creature);
    }

    public function destroy(Creature $creature)
    {
        $this->authorize('destroy', $creature);

        if (File::exists(public_path('images/uploads/' . $creature->avatar))) {
            File::delete(public_path('images/uploads/' . $creature->avatar));
        }

        $creature->delete();
        return response()->json(['count' => Creature::count()]);
    }
}