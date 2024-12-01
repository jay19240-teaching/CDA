<?php

namespace Database\Factories;

use App\Models\Creature;
use App\Models\Weapon;
use App\Models\CreatureWeapon;
use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreatureWeapon>
 */
class CreatureWeaponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creature_id' => random_int(1, Creature::count()),
            'weapon_id' => random_int(1, Weapon::count())
        ];
    }
}