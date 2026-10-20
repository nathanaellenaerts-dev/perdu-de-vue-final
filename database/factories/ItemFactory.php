<?php

namespace Database\Factories;

use App\Enums\Color;
use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $foundOn = $this->faker->dateTimeBetween('2026-10-01', '2026-10-25');
        $isReturned = $this->faker->boolean(20); // 20% de chance d'être restitué

        return [
            'place_id' => Place::factory(),
            'name' => $this->faker->unique()->lexify('Objet ???'),
            'description' => $this->faker->sentence(),
            'color' => $this->faker->randomElement(Color::cases()),
            'found_on' => $foundOn,
            'returned_at' => $isReturned ? (clone $foundOn)->modify('+'.rand(1, 5).' days') : null,
        ];
    }
}
