<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\Events\AttributeUpdated;
use App\Jobs\ProcessUserAttributeUpdates;
use App\Listeners\TriggerBatchUpdate;
use App\Models\UserAttributesUpdate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\Attributes\After;
use Tests\TestCase;

final class TriggerBatchUpdateTest extends TestCase
{
    use RefreshDatabase;

    #[After]
    public function cleanUp()
    {
        Redis::flushDb();
    }

    public function testBatchUpdateDispatch(): void
    {
        Queue::fake();
        UserAttributesUpdate::factory()->count(500)->create();
        $listener = new TriggerBatchUpdate();
        $event = new AttributeUpdated(UserAttributesUpdate::first());
        $listener->handle($event);

        Queue::assertNothingPushed();

        UserAttributesUpdate::factory()->count(500)->create();
        $listener->handle($event);

        Queue::assertPushedOn('batch-updates', ProcessUserAttributeUpdates::class);
    }
}
