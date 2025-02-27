<?php

use App\Models\API\Airport;
use App\Models\API\Locale;

const ICAO = 'EHAM';
const IATA = 'AMS';
const NAME = 'Schiphol';
const CITY = 'Amsterdam';
const COUNTRY = 'The Netherlands';

test('create', function () {
    $airport = Airport::create([
        'icao' => ICAO,
        'iata' => IATA,
        'name' => NAME,
        'locale' => [
            'city' => CITY,
            'country' => COUNTRY,
        ],
    ]);

    $this->assertEquals(ICAO, $airport->icao);
    $this->assertEquals(IATA, $airport->iata);
    $this->assertEquals(NAME, $airport->name);
    $this->assertInstanceOf(Locale::class, $airport->locale);
});

test('full description', function () {
    /** @var Airport $airport */
    $airport = Airport::factory()->create();

    $url = "https://fshub.io/airport/$airport->icao/overview";

    $expectedDescription = "$airport->name, {$airport->locale->city}\n{$airport->locale->country}\n([_$airport->icao, {$airport->iata}_]($url))";

    $this->assertEquals($expectedDescription, $airport->fullDescription());
});

test('short description', function () {
    /** @var Airport $airport */
    $airport = Airport::factory()->create();

    $url = "https://fshub.io/airport/$airport->icao/overview";

    $expectedDescription = "[$airport->name ($airport->icao)]($url)";

    $this->assertEquals($expectedDescription, $airport->shortDescription());
});
