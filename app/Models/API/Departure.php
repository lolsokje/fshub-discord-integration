<?php

declare(strict_types=1);

namespace App\Models\API;

use App\Contracts\HasDetailsEmbedField;
use App\Contracts\HasEmbedField;
use App\Models\Discord\Embed\EmbedField;
use Illuminate\Support\Carbon;

final readonly class Departure implements HasEmbedField, HasDetailsEmbedField
{
    public function __construct(
        public Airport $airport,
        public Wind $wind,
        public Carbon $timestamp,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            airport: Airport::create($content['airport']),
            wind: Wind::create($content['wind']),
            timestamp: Carbon::createFromFsHubTimestamp($content['departure_at']),
        );
    }

    public function embedField(): EmbedField
    {
        return EmbedField::create()
            ->setTitle('Departure airport')
            ->setContent($this->airport->fullDescription())
            ->setInline();
    }

    public function detailsEmbedField(): EmbedField
    {
        // https://www.geonames.org/export/web-services.html
        // http://api.geonames.org/timezoneJSON?lat=47.01&lng=10.2&username=demo
        $departureDetails = "
            **Time**: {$this->timestamp->toFsHubDateTimeString()}
            **Wind**: {$this->wind->format()}
        ";

        return EmbedField::create()
            ->setTitle('Departure details')
            ->setContent($departureDetails)
            ->setInline();
    }
}
