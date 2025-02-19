<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\API\FlightCompleted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

final class FlightCompletedNotificationJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $uniqueFor = 3600;

    public function __construct(
        public FlightCompleted $flightCompleted,
    ) {
    }

    public function handle(): void
    {
        dd($this->flightCompleted);
    }

    public function uniqueId(): int
    {
        return $this->flightCompleted->id;
    }
}
