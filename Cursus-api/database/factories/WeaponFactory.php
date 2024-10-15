<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weapon>
 */
class WeaponFactory extends Factory
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
            'power' => random_int(1, 30),
            'strong' => random_int(1, 30),
            'type' => fake()->randomElements(['SWORD', 'HALBARD', 'GUN'])[0]
        ];
    }
}