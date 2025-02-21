<?php

declare(strict_types=1);

namespace App\Models\API;

use Illuminate\Support\Carbon;

final readonly class Departure
{
    private function __construct(
        public Airport $airport,
        public Carbon $timestamp,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            airport: Airport::create($content['airport']),
            timestamp: Carbon::createFromFsHubTimestamp($content['departure_at']),
        );
    }
}
