<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Listing;

class ListingImagesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'listing_id' => Listing::factory(),
            'image_url' => fake()->imageUrl(800, 600, 'house', true),
            'is_primary' => fake()->boolean(30),
        ];
    }
}
