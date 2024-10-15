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
        // $this->middleware('auth:sanctum')
        // ->only([
        //     'destroy',
        //     'store',
        //     'update',
        //     'show'
        // ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Creature::all());
    }

    /**
     * Display a listing of user resource.
     */
    public function indexByUser(User $user = null)
    {
        $creatures = DB::table('creatures')->where('user_id', '=', $user->id)->get();
        return response()->json($creatures);
    }

    public function getWeapons(Request $request, string $id) {
        $creature = Creature::find($id);
        return response()->json($creature->weapons);
    }

    /**
     * Display a paginate listing of the resource.
     */
    public function paginate(Request $request)
    {
        $page = $request->query('page', 1);
        $name = $request->query('name');
        $minPv = $request->query('minPv');
        $maxPv = $request->query('maxPv');
        $limit = 3;

        $results = Creature::search($name, $minPv, $maxPv, $page, $limit);
        $maxPages = ceil($results['totalResults'] / $limit);

        return response()->json([
            'creatures' => $results['creatures'],
            'maxPages' => $maxPages,
            'page' => $page
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $creature->fill($formFields);
        $creature->user_id = Auth::user()->id;

        if ($request->file('avatar_blob')) {
            $fileName = time() . '_' . $request->avatar_blob->getClientOriginalName();
            $creature->avatar = $fileName;
            $request->avatar_blob->move(public_path('images/uploads'), $fileName);
        }

        $creature->save();
        return response()->json($creature);
    }

    /**
     * Display the specified resource.
     */
    public function show(Creature $creature)
    {
        return response()->json($creature);
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Creature $creature)
    {
        $this->authorize('destroy', $creature);
        $creature->delete();
        return response()->json(['count' => Creature::count()]);
    }
}