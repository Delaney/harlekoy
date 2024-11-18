<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\AttributeUpdated;
use App\Jobs\ProcessUserAttributeUpdates;
use App\Models\BatchUpdateTracker;
use App\Models\UserAttributesUpdate;
use Illuminate\Support\Facades\Redis;

final class TriggerBatchUpdate
{
    protected const LOCK_NAME = 'process_user_attributes_updates_lock';
    protected const QUEUE_NAME = 'batch-updates';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(AttributeUpdated $event): void
    {
        $unprocessedCount = UserAttributesUpdate::unprocessed()->count();

        $batchSize = config('services.batch.request_size');
        if ($unprocessedCount >= $batchSize
            && !BatchUpdateTracker::hasReachedLimit()
            && !Redis::get(self::LOCK_NAME)
        ) {
            Redis::set(self::LOCK_NAME, true, 'EX', 60);
            dispatch(new ProcessUserAttributeUpdates())->onQueue(self::QUEUE_NAME);
        }
    }
}
