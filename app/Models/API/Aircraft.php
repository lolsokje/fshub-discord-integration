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
        if (!$this->registration) {
            return 'N/A';
        }

        return "[$this->registration](https://www.jetphotos.com/registration/$this->registration)";
    }

    public function url(): string
    {
        if ($this->hasUnknownIcao()) {
            return '';
        }

        return "[$this->icao](https://duckduckgo.com/?q=$this->icao+aircraft)";
    }

    private function hasUnknownIcao(): bool
    {
        return $this->icao === '????';
    }
}
