<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Listing;
use App\Models\User;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'listing_id' => Listing::factory(),
            'tenant_id' => User::factory()->state(['role' => 'tenant']),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence(10),
            'created_at' => now(),
        ];
    }
}
