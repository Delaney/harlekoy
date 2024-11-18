<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * BatchUpdateTracker
 *
 * @property int $batch_updates_made
 */
final class BatchUpdateTracker extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'batch_updates_made',
    ];

    public static function hasReachedLimit(): bool
    {
        $tracker = self::first();
        $limit = (int) config('services.batch.request_size');
        return $tracker->batch_updates_made >= $limit;
    }

    public static function reset(): void
    {
        $tracker = self::first();
        $tracker->update(['batch_updates_made' => 0]);
    }
}
