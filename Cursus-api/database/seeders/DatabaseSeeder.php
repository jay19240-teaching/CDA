<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Creature;
use App\Models\CreatureWeapon;
use App\Models\Weapon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        Creature::factory(20)->create();
        CreatureWeapon::factory(100)->create();
    }
}