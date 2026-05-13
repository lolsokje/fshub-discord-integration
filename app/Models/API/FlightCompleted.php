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
        if (! $this->isSlipstreamFlight()) {
            return $this->plan->callsign ? "Flight {$this->plan->callsign} has arrived!" : 'A flight has arrived!';
        }

        $name = $this->slipstreamVariant($this->plan->callsign);

        return "$name flight {$this->plan->callsign} has arrived!";
    }

    public function description(): string
    {
        $callsign = $this->plan->callsign;

        $departureAndDestination = "from {$this->departure->airport->shortDescription()} to {$this->arrival->airport->shortDescription()}";
        $name = $this->slipstreamVariant($callsign);

        if ($this->isSlipstreamFlight()) {
            $intro = "$name flight [$callsign]({$this->url()})";
        } elseif ($callsign) {
            $intro = "Flight [$callsign]({$this->url()})";
        } else {
            $intro = "A [flight]({$this->url()})";
        }

        return "$intro $departureAndDestination has arrived!";
    }

    public function detailsEmbedField(): EmbedField
    {
        if ($this->aircraft->hasRegistration()) {
            $flightDetails = "
            **Aircraft**: {$this->aircraft->identification()}
            **Registration**: {$this->aircraft->fullRegistration()}
            **Flight time**: {$this->duration()}
        ";
        } else {
            $flightDetails = "
            **Aircraft**: {$this->aircraft->identification()}
            **Flight time**: {$this->duration()}
        ";
        }

        return EmbedField::create()
            ->setTitle('Flight details')
            ->setContent($flightDetails);
    }

    private function isSlipstreamFlight(): bool
    {
        if (! $this->plan->callsign) {
            return false;
        }

        return str_starts_with($this->plan->callsign, 'SSA') || str_starts_with($this->plan->callsign, 'SSC');
    }

    private function slipstreamVariant(?string $callsign): string
    {
        if (! $callsign) {
            return '';
        }

        if (str_starts_with($callsign, 'SSA')) {
            return 'Slipstream Airways';
        }

        return 'Slipstream Cargo';
    }
}
