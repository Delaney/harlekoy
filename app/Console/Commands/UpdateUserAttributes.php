<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Timezones;
use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Console\Command;

final class UpdateUserAttributes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-attributes {--ids= : IDs of users to update (1,2,3)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batch update user attributes with random values';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $ids = $this->option('ids');
        $users = empty($ids) ?
            User::all() : User::whereIn('id', explode(',', $ids))->get();
        $timezones = Timezones::values();

        foreach ($users as $user) {
            $user->update([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'time_zone' => $timezones[array_rand($timezones)],
            ]);
        }

        $count = $users->count();
        $this->info("Attributes updated successfully, User Count = {$count}.");
    }

    private function faker(): Generator
    {
        return Factory::create();
    }
}
