<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Weapon;
use App\Models\Creature;
use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Creature>
 */
class CreatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'pv' => random_int(0, 100),
            'atk' => random_int(0, 100),
            'def' => random_int(0, 100),
            'speed' => random_int(0, 100),
            'type' => CreatureTypeEnum::random(),
            'race' => CreatureRaceEnum::random(),
            'capture_rate' => random_int(0, 100),
            'user_id' => random_int(1, 2)
        ];
    }
}