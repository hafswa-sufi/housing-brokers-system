<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Listing;
use App\Models\User;

class BookingsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => User::factory()->state(['role' => 'tenant']),
            'listing_id' => Listing::factory(),
            'status' => fake()->randomElement(['pending', 'accepted', 'rejected', 'completed', 'canceled']),
            'scheduled_date' => fake()->dateTimeBetween('+1 days', '+1 month'),
            'created_at' => now(),
        ];
    }
}
