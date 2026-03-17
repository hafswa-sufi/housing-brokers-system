<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agent;
use App\Models\Listing;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        User::factory(10)->create();
        echo "✅ Created 10 users\n";

        // Create 5 agents
        Agent::factory(5)->create();
        echo "✅ Created 5 agents\n";

        // Create 20 listings
        Listing::factory(20)->create();
        echo "✅ Created 20 listings\n";

        echo "🎉 Basic seeding completed successfully!\n";
        
        // Comment out problematic factories for now
        // We'll fix these later after the admin page works
        
        // ListingImages::factory(40)->create();
        // Review::factory(30)->create();
        // Bookings::factory(15)->create();
        // Reports::factory(10)->create();
        // Blacklist::factory(3)->create();
        // $this->call(TestDataSeeder::class);
    }
}

