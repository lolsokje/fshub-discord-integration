<?php

declare(strict_types=1);

namespace App\Parsers;

use App\Models\API\FlightCompleted;

final readonly class FsHubWebhookParser
{
    public function flightCompleted(
        array $content,
    ): FlightCompleted {
        return FlightCompleted::create($content['_data']);
    }
}
