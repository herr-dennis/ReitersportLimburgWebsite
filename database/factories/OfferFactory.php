<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->text(200),
            'image' => fake()->imageUrl(640, 480, 'animals', true), // Platzhalter-Bild
            'price' => fake()->numberBetween(1, 100),
        ];
    }
}
