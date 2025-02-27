<?php

declare(strict_types=1);

namespace App\Models\API;

use App\Contracts\HasDetailsEmbedField;
use App\Contracts\HasEmbedField;
use App\Models\Discord\Embed\EmbedField;
use Illuminate\Support\Carbon;

final readonly class Arrival implements HasEmbedField, HasDetailsEmbedField
{
    public function __construct(
        public Airport $airport,
        public int $landingRate,
        public Wind $wind,
        public Carbon $timestamp,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            airport: Airport::create($content['airport']),
            landingRate: $content['landing_rate'],
            wind: Wind::create($content['wind']),
            timestamp: Carbon::createFromFsHubTimestamp($content['arrival_at']),
        );
    }

    public function embedField(): EmbedField
    {
        return EmbedField::create()
            ->setTitle('Arrival airport')
            ->setContent($this->airport->fullDescription())
            ->setInline();
    }

    public function detailsEmbedField(): EmbedField
    {
        $arrivalDetails = "
            **Time**: {$this->timestamp->toFsHubDateTimeString()}
            **Landing rate**: {$this->landingRate}fpm
            **Wind**: {$this->wind->format()}
        ";

        return EmbedField::create()
            ->setTitle('Arrival details')
            ->setContent($arrivalDetails)
            ->setInline();
    }
}
