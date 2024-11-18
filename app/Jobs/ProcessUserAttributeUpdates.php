<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\BatchUpdateTracker;
use App\Models\UserAttributesUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class ProcessUserAttributeUpdates implements ShouldQueue
{
    use Queueable;

    protected const URL = 'https://provider.com/batch-endpoint';

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (BatchUpdateTracker::hasReachedLimit()) {
            return;
        }

        $updates = UserAttributesUpdate::unProcessed()
            ->limit(1000)
            ->get();

        if ($updates->isEmpty()) {
            return;
        }

        $payload = $this->generatePayload($updates);

        $response = Http::post(
            self::URL,
            $payload
        );

        if ($response->successful()) {
            $updates->each->update(['processed' => true]);
            $this->incrementTracker();
        } else {
            Log::error('Batch update failed.', [
                'response' => $response->body(),
            ]);
        }
    }

    /**
     * Generate payload for provider batch API
     *
     * @param Collection<UserAttributesUpdate> $updates
     * @return array
     */
    private function generatePayload(Collection $updates): array
    {
        return [
            'batches' => [
                'subscribers' => $updates->map(fn ($update) => [
                    'email' => $update->email,
                    ...$update->attributes,
                ])->toArray(),
            ],
        ];
    }

    private function incrementTracker(): void
    {
        $tracker = BatchUpdateTracker::first();
        $tracker->increment('batch_updates_made');
    }
}
