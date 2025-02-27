<?php

declare(strict_types=1);

namespace Database\Factories\API;

use App\Models\API\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class LocaleFactory extends Factory
{
    protected $model = Locale::class;

    public function definition(): array
    {
        return [
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
        ];
    }

    public function create($attributes = [], ?Model $parent = null): Locale
    {
        $data = array_merge($this->definition(), $attributes);

        return Locale::create($data);
    }
}
