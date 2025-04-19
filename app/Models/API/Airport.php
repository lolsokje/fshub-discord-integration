<?php

declare(strict_types=1);

namespace App\Models\API;

use App\Contracts\IsAirport;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final readonly class Airport implements IsAirport
{
    use HasFactory;

    public function __construct(
        public string $icao,
        public ?string $iata,
        public string $name,
        public Locale $locale,
    ) {
    }

    public static function create(
        ?array $content,
    ): ?IsAirport {
        if (!$content) {
            return new NullAirport();
        }

        return new self(
            icao: $content['icao'],
            iata: $content['iata'],
            name: $content['name'],
            locale: Locale::create($content['locale']),
        );
    }

    public function fullDescription(): string
    {
        $airportCodes = $this->iata ? "_$this->icao, {$this->iata}_" : "_{$this->icao}_";

        $locale = "$this->name";

        if ($this->locale->city) {
            $locale .= ", {$this->locale->city}";
        }

        return "$locale\n{$this->locale->country}\n([$airportCodes]({$this->airportUrl()}))";
    }

    public function shortDescription(): string
    {
        return "[$this->name ($this->icao)]({$this->airportUrl()})";
    }

    private function airportUrl(): string
    {
        return "https://fshub.io/airport/{$this->icao}/overview";
    }
}
