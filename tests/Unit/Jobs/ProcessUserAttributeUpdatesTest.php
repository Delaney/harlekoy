<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessUserAttributeUpdates;
use App\Models\UserAttributesUpdate;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class ProcessUserAttributeUpdatesTest extends TestCase
{
    public function TestBatchUpdateProcessing(): void
    {
        UserAttributesUpdate::factory()->count(1000)->create();
        $this->assertEquals(1000, UserAttributesUpdate::unProcessed()->count());

        Http::fake();

        $job = new ProcessUserAttributeUpdates();
        $job->handle();

        Http::assertSent(fn ($request) => $request->url() === 'https://provider.com/batch-endpoint');

        $this->assertDatabaseCount('user_attributes_updates', 1000);
        $this->assertEquals(0, UserAttributesUpdate::unProcessed()->count());
    }
}
