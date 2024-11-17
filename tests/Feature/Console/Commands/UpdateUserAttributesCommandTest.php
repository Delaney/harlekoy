<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use App\Enums\Timezones;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UpdateUserAttributesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $timezones = Timezones::values();
        User::factory()->count(10)->create([
            'first_name' => 'Name',
            'last_name' => 'Name',
        ]);

        $this->artisan('user:update-attributes')
            ->expectsOutput('Attributes updated successfully, User Count = 10')
            ->assertExitCode(0);

        $updatedUsers = User::all();
        $updatedUsers->each(function (User $user) use ($timezones) {
            $this->assertNotEquals('Name', $user->first_name);
            $this->assertNotEquals('Name', $user->last_name);
            $this->assertContains($user->time_zone, $timezones);
        });
    }
}
