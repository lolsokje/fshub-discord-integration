<?php

use App\Models\Color;

test('hexadecimal colours can be converted to decimal', function (string $hex, int $decimal) {
    $color = Color::createFromString($hex);

    $this->assertEquals($decimal, $color->toDecimal());
})->with([
    ['#022B5B', 142171],
    ['#FF7900', 16742656],
]);
