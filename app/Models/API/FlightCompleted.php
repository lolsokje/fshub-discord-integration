<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class FlightCompleted
{
    private function __construct(
        public int $id,
        public FsHubUser $user,
        public Aircraft $aircraft,
        public Airline $airline,
        public Plan $plan,
        public Departure $departure,
        public Arrival $arrival,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            id: $content['id'],
            user: FsHubUser::create($content['user']),
            aircraft: Aircraft::create($content['aircraft']),
            airline: Airline::create($content['airline']),
            plan: Plan::create($content['plan']),
            departure: Departure::create($content['departure']),
            arrival: Arrival::create($content['arrival']),
        );
    }
}
