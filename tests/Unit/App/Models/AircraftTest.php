<?php

use App\Models\API\Aircraft;

test('create', function () {
    $aircraft = Aircraft::create([
        'icao' => 'B738',
        'icao_name' => 'Boeing 737-800',
        'user_conf' => [
            'tail' => 'PH-ABC',
        ],
    ]);

    $this->assertEquals('B738', $aircraft->icao);
    $this->assertEquals('Boeing 737-800', $aircraft->name);
    $this->assertEquals('PH-ABC', $aircraft->registration);
});

test('registration', function (?string $registration, string $expectedResult) {
    $aircraft = new Aircraft(
        icao: 'B738',
        name: 'Boeing 737-800',
        registration: $registration,
    );

    $this->assertEquals($expectedResult, $aircraft->registration());
})->with([
    [null, 'N/A'],
    ['PH-ABC', '[PH-ABC](https://www.jetphotos.com/registration/PH-ABC)'],
]);

test('url', function () {
    $aircraft = new Aircraft(
        icao: 'B738',
        name: 'Boeing 737-800',
        registration: 'PH-ABC',
    );

    $this->assertEquals('[B738](https://duckduckgo.com/?q=B738+aircraft)', $aircraft->url());
});
