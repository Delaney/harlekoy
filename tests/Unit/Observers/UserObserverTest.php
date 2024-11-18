<?php

declare(strict_types=1);

namespace Tests\Unit\Observers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserObserverTest extends TestCase
{
    use RefreshDatabase;

    public function testOnlyChangedAttributesEnqueued(): void
    {
        $user = User::factory()->create();

        $user->update(['time_zone' => 'CST']);

        $this->assertDatabaseHas('user_attributes_updates', [
            'email' => $user->email,
            'attributes->time_zone' => 'CST',
        ]);

        $this->assertDatabaseCount('user_attributes_updates', 1);
    }
}
