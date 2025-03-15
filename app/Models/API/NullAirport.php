<?php

declare(strict_types=1);

namespace App\Models\API;

use App\Contracts\IsAirport;

class NullAirport implements IsAirport
{
    public function fullDescription(): string
    {
        return 'Unknown';
    }

    public function shortDescription(): string
    {
        return 'Unknown';
    }
}
