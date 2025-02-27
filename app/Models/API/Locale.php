<?php

declare(strict_types=1);

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final readonly class Locale
{
    use HasFactory;

    public function __construct(
        public string $city,
        public string $country,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            city: $content['city'],
            country: $content['country'],
        );
    }
}
