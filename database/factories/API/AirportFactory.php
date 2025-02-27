<?php

declare(strict_types=1);

namespace Database\Factories\API;

use App\Models\API\Airport;
use App\Models\API\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class AirportFactory extends Factory
{
    protected $model = Airport::class;

    public function definition(): array
    {
        return [
            'icao' => $this->faker->lexify(),
            'iata' => $this->faker->lexify('???'),
            'name' => $this->faker->word(),
            'locale' => Locale::factory()->create(),
        ];
    }

    public function create($attributes = [], ?Model $parent = null): Airport
    {
        $data = array_merge($this->definition(), $attributes);

        $locale = [
            'city' => $data['locale']->city,
            'country' => $data['locale']->country,
        ];

        $data['locale'] = $locale;

        return Airport::create($data);
    }
}
