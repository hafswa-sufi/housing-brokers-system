<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->state([
    'role' => 'agent',
]), // creates linked user
            'verification_status' => fake()->randomElement(['pending','verified','rejected']),
            'id_document_url' => fake()->imageUrl(),
            'license_number' => fake()->bothify('LIC-####'),
            'bio' => fake()->paragraph(),
            'rating_avg' => fake()->randomFloat(1, 2.5, 5.0),
        ];
    }
}
