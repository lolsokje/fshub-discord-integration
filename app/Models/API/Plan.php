<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class Plan
{
    public function __construct(
        public ?string $callsign,
    ) {
    }

    public static function create(
        ?array $content,
    ): self {
        return new self(
            callsign: $content['callsign'] ?? null,
        );
    }
}
