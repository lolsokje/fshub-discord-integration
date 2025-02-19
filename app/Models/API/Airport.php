<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class Airport
{
    private function __construct(
        public string $icao,
        public string $iata,
        public string $name,
        public string $city,
        public string $country,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            icao: $content['icao'],
            iata: $content['iata'],
            name: $content['name'],
            city: $content['locale']['city'],
            country: $content['locale']['country']
        );
    }
}
