<?php

declare(strict_types=1);

namespace App\Models\API;

final readonly class Aircraft
{
    public function __construct(
        public string $icao,
        public string $name,
        public ?string $registration,
    ) {
    }

    public static function create(
        array $content,
    ): self {
        return new self(
            icao: $content['icao'],
            name: $content['icao_name'],
            registration: $content['user_conf']['tail'],
        );
    }

    public function identification(): string
    {
        if ($this->hasUnknownIcao()) {
            return $this->name;
        }

        return "$this->name ({$this->url()})";
    }

    public function registration(): string
    {
        if (! $this->registration) {
            return 'N/A';
        }

        return "[$this->registration](https://www.jetphotos.com/registration/$this->registration)";
    }

    public function fullRegistration(): string
    {
        $aircraftName = $this->getAircraftName();

        if (! $aircraftName) {
            return $this->registration();
        }

        return "$this->registration \"$aircraftName\"";
    }

    public function url(): string
    {
        if ($this->hasUnknownIcao()) {
            return '';
        }

        return "[$this->icao](https://duckduckgo.com/?q=$this->icao+aircraft)";
    }

    public function hasRegistration(): bool
    {
        return $this->registration !== null;
    }

    private function getAircraftName(): ?string
    {
        return match ($this->registration) {
            'N1717H' => 'Michael Schumacher',
            'EC-MEN' => 'Juan Manuel Fangio',
            'G-YOSH' => 'Sebastian Vettel',
            'PH-MKA' => 'Max Verstappen',
            'PH-SOK' => 'Niki Lauda',
            'N1496J' => 'Jackie Stewart',
            'PH-PKY' => 'Jim Clark',
            'HL2006' => 'Fernando Alonso',
            'OH-DZT' => 'Mika Häkkinen',
            'PH-DUH' => 'Lando Norris',
            'PH-STL' => 'Kimi Räikkönen',
            default => null,
        };
    }

    private function hasUnknownIcao(): bool
    {
        return $this->icao === '????';
    }
}
