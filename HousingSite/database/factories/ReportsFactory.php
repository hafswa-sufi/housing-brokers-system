<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Listing;

class ReportsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reported_by' => User::factory(),
            'listing_id' => Listing::factory(),
            'reason' => fake()->sentence(12),
            'status' => fake()->randomElement(['pending', 'reviewed', 'resolved']),
            'created_at' => now(),
        ];
    }
}
