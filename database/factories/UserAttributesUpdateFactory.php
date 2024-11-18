<?php

namespace Database\Factories;

use App\Enums\Timezones;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAttributesUpdate>
 */
class UserAttributesUpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timezones = Timezones::values();
        return [
            'email' => fake()->unique()->safeEmail(),
            'attributes' => [
                'name' => fake()->name,
                'time_zone' => $timezones[array_rand($timezones)],
            ],
        ];
    }
}
