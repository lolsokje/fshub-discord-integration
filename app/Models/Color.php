<?php

declare(strict_types=1);

namespace App\Models;

final readonly class Color
{
    public function __construct(
        private string $value,
    ) {
    }

    public static function createFromString(
        string $code,
    ): self {
        $code = str_replace('#', '', $code);

        return new self(
            value: $code,
        );
    }

    public function toDecimal(): int
    {
        $parts = str_split($this->value, 2);
        $keys = array_reverse(array_keys($parts));

        $results = [];

        // (R * 256^2) + (G * 256^1) + (B * 256^0)
        foreach ($parts as $index => $part) {
            $multiplication = $keys[$index];

            $decimalPart = hexdec($part);

            $results[] = $decimalPart * 256 ** $multiplication;
        }

        return array_sum($results);
    }
}
