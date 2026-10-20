<?php


namespace Database\Factories;

use App\Enums\PlaceKind;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Hall central', 'Quai A', 'Quai B', 'Voie 3', 'Train Intercity']),
            'kind' => $this->faker->randomElement(PlaceKind::cases()),
        ];
    }
}

