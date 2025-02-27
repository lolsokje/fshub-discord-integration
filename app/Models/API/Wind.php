<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class Wind
{
    public function __construct(
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

    public function format(): string
    {
        $direction = str_pad("$this->direction", 3, '0', STR_PAD_LEFT);

        return "$direction@{$this->speed}kts";
    }
}
