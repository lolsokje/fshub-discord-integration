<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Jobs\FlightCompletedNotificationJob;
use App\Parsers\FsHubWebhookParser;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class FlightCompletedController
{
    public function __construct(
        private LogManager $logger,
        private FsHubWebhookParser $webhookParser,
    ) {
    }

    public function __invoke(
        Request $request,
    ): JsonResponse {
        $content = $request->json()->all();

        $this->logger->channel('webhooks')->info(json_encode($content));

        $event = $this->webhookParser->flightCompleted($content);

        FlightCompletedNotificationJob::dispatch($event);

        return new JsonResponse(
            status: 200,
        );
    }
}
