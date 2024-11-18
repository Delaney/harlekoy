<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BatchUpdateTracker;
use Illuminate\Console\Command;

final class ResetBatchCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:reset-counter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset batch update counter hourly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        BatchUpdateTracker::reset();
    }
}
