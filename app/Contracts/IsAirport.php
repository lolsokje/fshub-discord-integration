<?php

declare(strict_types=1);

namespace App\Contracts;

interface IsAirport
{
    public function fullDescription(): string;

    public function shortDescription(): string;
}
