<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Timezones;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timezones = Timezones::values();

        for ($i = 1; $i <= 20; $i++) {
            User::factory()->create([
                'time_zone' => $timezones[array_rand($timezones)],
            ]);
        }
    }
}
