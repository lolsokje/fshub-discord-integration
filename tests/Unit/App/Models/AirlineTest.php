<?php

use App\Models\API\Airline;

test('create', function () {
    $airline = Airline::create([
        'id' => 1,
        'name' => 'KLM',
    ]);

    $this->assertEquals(1, $airline->id);
    $this->assertEquals('KLM', $airline->name);
});
