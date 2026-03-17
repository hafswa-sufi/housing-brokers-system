<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Agent;
use App\Models\Listing;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create a test admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@casaamor.com',
            'phone' => '+254700000000',
            'password_hash' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create a test agent user
        $agentUser = User::create([
            'name' => 'Test Agent',
            'email' => 'agent@casaamor.com', 
            'phone' => '+254711111111',
            'password_hash' => Hash::make('password'),
            'role' => 'agent',
        ]);

        // Create agent profile
        $agent = Agent::create([
            'user_id' => $agentUser->user_id, // ✅ link to existing user
            'license_number' => 'RE-123456',
            'verification_status' => 'verified',
            'bio' => 'Professional real estate agent with 5 years experience.',
        ]);

        // Create some test listings
        // Listing::create([
        //     'agent_id' => $agent->agent_id,
        //     'title' => 'Beautiful 3-Bedroom House in Karen',
        //     'description' => 'Spacious family home with modern amenities and great neighborhood.',
        //     'price' => 25000000,
        //     'location' => 'Karen, Nairobi',
        //     'status' => 'available',
        //     'property_type' => 'House',
        //     'bedrooms' => 3,
        //     'bathrooms' => 2,
        //     'garage' => 2,
        //     'size' => 2800,
        // ]);

        // Listing::create([
        //     'agent_id' => $agent->agent_id,
        //     'title' => 'Modern Apartment in Westlands',
        //     'description' => 'Luxury apartment with stunning city views and amenities.',
        //     'price' => 15000000,
        //     'location' => 'Westlands, Nairobi',
        //     'status' => 'available', 
        //     'property_type' => 'Apartment',
        //     'bedrooms' => 2,
        //     'bathrooms' => 2,
        //     'garage' => 1,
        //     'size' => 1200,
        // ]);

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Admin: admin@casaamor.com / password');
        $this->command->info('Agent: agent@casaamor.com / password');
    }
}