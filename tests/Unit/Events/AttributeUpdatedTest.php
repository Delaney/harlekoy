<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\Events\AttributeUpdated;
use App\Models\User;
use App\Models\UserAttributesUpdate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AttributeUpdatedTest extends TestCase
{
    use RefreshDatabase;

    public function testEvent(): void
    {
        $userAttributesUpdate = UserAttributesUpdate::createUpdate(
            User::factory()->create(),
            [
                'time_zone' => 'CST',
            ]
        );
        $event = new AttributeUpdated($userAttributesUpdate);

        $this->assertEquals($userAttributesUpdate->id, $event->userAttributesUpdate->id);
    }
}
