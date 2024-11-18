<?php

namespace Tests\Feature\Console\Commands;

use App\Models\BatchUpdateTracker;
use Tests\TestCase;

class ResetBatchCounterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testResetBatchCounter(): void
    {
        $tracker = BatchUpdateTracker::first();
        $tracker->update(['batch_updates_made' => 10]);

        $this->artisan('batch:reset-counter')
            ->doesntExpectOutput();

        $tracker->refresh();
        $this->assertEquals(0, $tracker->batch_updates_made);
    }
}
