<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\UserAttributesUpdate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserAttributesUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUpdateMethod()
    {
        $user = User::factory()->create([
            'time_zone' => 'CST'
        ]);

        $userAttributesUpdate = UserAttributesUpdate::createUpdate($user, [
            'time_zone' => 'CST',
        ]);

        $this->assertDatabaseCount('user_attributes_updates', 1);
        $this->assertDatabaseHas('user_attributes_updates', [
            'email' => $user->email,
            'processed' => false,
        ]);
        $this->assertEquals(['time_zone' => 'CST'], $userAttributesUpdate->attributes);
    }
}
