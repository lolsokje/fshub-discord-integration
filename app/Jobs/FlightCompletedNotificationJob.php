<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\API\FlightCompleted;
use App\Models\Color;
use App\Models\Discord\Embed\Embed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Http\Client\Factory;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

final class FlightCompletedNotificationJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $uniqueFor = 3600;

    public function __construct(
        public FlightCompleted $flightCompleted,
    ) {
    }

    public function handle(
        Factory $client,
    ): void {
        $embed = Embed::create()
            ->setTitle($this->flightCompleted->title())
            ->setAuthor($this->flightCompleted->user->name)
            ->setAuthorIconUrl($this->flightCompleted->user->avatarUrl)
            ->setDescription($this->flightCompleted->description())
            ->setColor(Color::createFromString('#022B5B'))
            ->addField($this->flightCompleted->departure->embedField())
            ->addField($this->flightCompleted->arrival->embedField())
            ->addField($this->flightCompleted->detailsEmbedField())
            ->addField($this->flightCompleted->departure->detailsEmbedField())
            ->addField($this->flightCompleted->arrival->detailsEmbedField());

        $webhookUrl = config('discord.webhook.url');

        $data = [
            'content' => null,
            'embeds' => [$embed->format()],
        ];

        $client->post($webhookUrl, $data);
    }

    public function uniqueId(): int
    {
        return $this->flightCompleted->id;
    }
}
