<?php

declare(strict_types=1);

namespace App\Models\API;

use Illuminate\Support\Carbon;

final readonly class Arrival
{
    private function __construct(
        public Airport $airport,
        public int $landingRate,
        public Wind $wind,
        public Carbon $timestamp,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            airport: Airport::create($content['airport']),
            landingRate: $content['landing_rate'],
            wind: Wind::create($content['wind']),
            timestamp: Carbon::createFromFsHubTimestamp($content['arrival_at']),
        );
    }
}
