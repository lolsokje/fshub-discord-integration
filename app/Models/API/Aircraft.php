<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class Aircraft
{
    private function __construct(
        public string $icao,
        public string $name,
        public string $registration,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            icao: $content['icao'],
            name: $content['icao_name'],
            registration: $content['user_conf']['tail'],
        );
    }
}
