<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class Wind
{
    private function __construct(
        public int $speed,
        public int $direction,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            speed: $content['speed'],
            direction: $content['direction'],
        );
    }
}
