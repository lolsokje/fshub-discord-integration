<?php

declare(strict_types=1);

namespace App\Models\API;

use App\Contracts\HasDetailsEmbedField;
use App\Models\Discord\Embed\EmbedField;

final readonly class FlightCompleted implements HasDetailsEmbedField
{
    public function __construct(
        public int $id,
        public FsHubUser $user,
        public Aircraft $aircraft,
        public Airline $airline,
        public Plan $plan,
        public Departure $departure,
        public Arrival $arrival,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            id: $content['id'],
            user: FsHubUser::create($content['user']),
            aircraft: Aircraft::create($content['aircraft']),
            airline: Airline::create($content['airline']),
            plan: Plan::create($content['plan']),
            departure: Departure::create($content['departure']),
            arrival: Arrival::create($content['arrival']),
        );
    }

    public function url(): string
    {
        return "https://www.fshub.io/flight/$this->id/report";
    }

    public function duration(): string
    {
        $duration = $this->departure->timestamp->diff($this->arrival->timestamp);

        return "{$duration->hours}h {$duration->minutes}m";
    }

    public function title(): string
    {
        return $this->plan->callsign ? "Flight {$this->plan->callsign} has arrived!" : 'A flight has arrived!';
    }

    public function description(): string
    {
        $callsign = $this->plan->callsign;

        if ($callsign) {
            return "Flight [$callsign]({$this->url()}) from {$this->departure->airport->shortDescription()} to {$this->arrival->airport->shortDescription()} has arrived!";
        } else {
            return "A [flight]({$this->url()}) from {$this->departure->airport->shortDescription()} to {$this->arrival->airport->shortDescription()} has arrived!";
        }
    }

    public function detailsEmbedField(): EmbedField
    {
        $flightDetails = "
            **Aircraft**: {$this->aircraft->identification()}
            **Flight time**: {$this->duration()}
        ";

        // Registration seems to never be set?
        // **Registration**: {$this->registration()}

        return EmbedField::create()
            ->setTitle('Flight details')
            ->setContent($flightDetails);
    }
}
