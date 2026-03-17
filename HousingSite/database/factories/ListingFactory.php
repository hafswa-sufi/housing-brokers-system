<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Agent;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),

            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(5),
            'price' => fake()->randomFloat(2, 15000, 250000),
            'location' => fake()->city(),

            'bedrooms' => fake()->numberBetween(1, 6),
            'bathrooms' => fake()->numberBetween(1, 4),
            'property_type' => fake()->randomElement(['apartment', 'house', 'villa', 'studio']),
            'size' => fake()->numberBetween(20, 500),
            'garage' => fake()->boolean(),

            'status' => fake()->randomElement(['available', 'rented', 'removed', 'flagged']),
            'verification_status' => fake()->randomElement(['pending', 'verified', 'rejected']),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
