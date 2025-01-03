<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Creature;
use App\Models\CreatureWeapon;
use App\Models\Weapon;
use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur',
            'role' => 'ROLE_ADMIN',
            'email' => 'admin@pokedex.com',
            'password' => Hash::make('test123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'token' => Str::random(40)
        ]);

        User::create([
            'name' => 'Utilisateur',
            'role' => 'ROLE_USER',
            'email' => 'user@pokedex.com',
            'password' => Hash::make('test123'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'token' => Str::random(40)
        ]);

        User::factory(10)->create();
        Weapon::factory(10)->create();
        $this->creatureFactoryFromAPI(300); // or locally with: Creature::factory(20)->create();
        CreatureWeapon::factory(100)->create();
    }

    public function creatureFactoryFromAPI(int $limit = 100) {
        $resPokemons = Http::get('https://pokeapi.co/api/v2/pokemon?limit=' . $limit);
        $dataPokemons = $resPokemons->json();

        if ($resPokemons->status() == 200) {
            foreach ($dataPokemons['results'] as $pokemon) {
                $resPokemon = Http::get($pokemon['url']);
                $dataPokemon = $resPokemon->json();
                $attributes = [
                    'name' => $dataPokemon['name'],
                    'user_id' => 1,
                    'capture_rate' => 1,
                    'type' => CreatureTypeEnum::random(),
                    'race' => CreatureRaceEnum::random()
                ];

                if ($dataPokemon['sprites']['front_default']) {
                    $resImage = Http::get($dataPokemon['sprites']['front_default']);
                    $bodyImage = (string) $resImage->body();
                    Storage::put('public/pokemons/images/' . $dataPokemon['name'] . '.png', $bodyImage);
                    $attributes['avatar'] = $dataPokemon['name'] . '.png';
                }

                foreach ($dataPokemon['stats'] as $pokemonStat) {
                    if ($pokemonStat['stat']['name'] == 'hp') {
                        $attributes['pv'] = $pokemonStat['base_stat'];
                    }

                    if ($pokemonStat['stat']['name'] == 'attack') {
                        $attributes['atk'] = $pokemonStat['base_stat'];
                    }

                    if ($pokemonStat['stat']['name'] == 'defense') {
                        $attributes['def'] = $pokemonStat['base_stat'];
                    }

                    if ($pokemonStat['stat']['name'] == 'speed') {
                        $attributes['speed'] = $pokemonStat['base_stat'];
                    }

                    if ($pokemonStat['stat']['name'] == 'speed') {
                        $attributes['speed'] = $pokemonStat['base_stat'];
                    }
                }

                Creature::factory()->create($attributes);
            }
        }
    }
}