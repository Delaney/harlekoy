<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\BatchUpdateTracker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class BatchUpdateTrackerTest extends TestCase
{
    use RefreshDatabase;

    public function testBatchUpdateTrackerLimitCheck()
    {
        $this->assertDatabaseCount('batch_update_trackers', 1);
        $this->assertFalse(BatchUpdateTracker::hasReachedLimit());

        $tracker = BatchUpdateTracker::first();
        $tracker->update(['batch_updates_made' => 100000]);
        $tracker->refresh();

        $this->assertTrue(BatchUpdateTracker::hasReachedLimit());
    }

    public function testBatchUpdateTrackerReset()
    {
        $this->assertDatabaseCount('batch_update_trackers', 1);

        $tracker = BatchUpdateTracker::first();
        $tracker->update(['batch_updates_made' => 100000]);
        $tracker->refresh();

        $this->assertTrue(BatchUpdateTracker::hasReachedLimit());

        BatchUpdateTracker::reset();
        $tracker->refresh();

        $this->assertSame(0, $tracker->batch_updates_made);
    }
}
