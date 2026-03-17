<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookings;
use App\Models\Listing;
use Illuminate\Support\Facades\DB; // Needed for transactions
use Illuminate\Support\Facades\Session; // Needed for specific session flashes
// use App\Models\User; // You likely don't need to import User here

class BookingsController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // tenant_id uses the 'id' field in the 'users' table, not user_id
            'tenant_id' => 'required|exists:users,id', 
            'listing_id' => 'required|exists:listings,listing_id',
            'scheduled_date' => 'required|date|after_or_equal:today',
        ]);
        
        // Use a transaction for atomicity
        DB::beginTransaction();

        try {
            // Find the listing
            $listing = Listing::where('listing_id', $validatedData['listing_id'])->first();

            // 1. Availability Check
            if (!$listing || $listing->status !== 'available') { // Check for 'available' status 
                DB::rollBack();
                return response()->json([
                    'message' => 'Listing is not available for booking.',
                ], 409); // 409 Conflict
            }

            // The following line is optional if you have the boot() method in your model:
            // $validatedData['status'] = 'pending';

            // 2. Create the booking (Status defaults to 'pending' by model boot method)
            $booking = Bookings::create($validatedData);

            // 3. Update listing status → mark as booked (use "rented")
            $listing->status = 'rented'; // Status must be one of the enum values [cite: 168]
            $listing->save();

            // 4. Notify the agent using a specific key
            // This notification will only be displayed for the agent with this ID in the dashboard view
            Session::flash('agent_notification_' . $listing->agent_id, 
                "ALERT: Your listing **'{$listing->title}'** has been successfully booked for {$validatedData['scheduled_date']}."
            );
            
            DB::commit(); // Commit all changes

            return response()->json([
                'message' => 'Booking created and listing status updated.',
                'booking' => $booking
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback if any step fails
            // Log the error for debugging: \Log::error('Booking failed: ' . $e->getMessage()); 
            
            return response()->json([
                'message' => 'Failed to process booking. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}