<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    /**
     * Display a listing of the properties for admin.
     */
    public function index()
    {
         try {
            $listings = Listing::with(['agent.user'])
                ->withCount('bookings')
                ->latest()
                ->get();

            return view('dashboard.admin.listings.index', compact('listings'));
            
        } catch (\Exception $e) {
            Log::error('Admin listings error: ' . $e->getMessage());
            return view('dashboard.admin.listings.index')->with('listings', []);
        }
    }

    /**
     * Display the specified listing for admin.
     */
    public function show(Listing $listing)
    {
        try {
            $listing->load(['agent.user', 'images', 'bookings']);
            return view('dashboard.admin.listings.show', compact('listing'));
        } catch (\Exception $e) {
            Log::error('Admin listing show error: ' . $e->getMessage());
            return redirect()->route('admin.listings.index')
                ->with('error', 'Listing not found.');
        }
    }

    /**
     * Verify the listing.
     */
    public function verify(Listing $listing)
    {
        try {
            $listing->update(['verification_status' => 'verified']);
            return redirect()->back()->with('success', 'Listing has been successfully verified.');
        } catch (\Exception $e) {
            Log::error('Verification error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to verify listing.');
        }
    }

    /**
     * Reject the listing.
     */
    public function reject(Listing $listing)
    {
        try {
            $listing->update(['verification_status' => 'rejected']);
            return redirect()->back()->with('success', 'Listing has been rejected.');
        } catch (\Exception $e) {
            Log::error('Rejection error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reject listing.');
        }
    }

    /**
     * Delete the listing.
     */
    public function destroy(Listing $listing)
    {
        try {
            // Delete images from storage
            foreach ($listing->images as $image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }
            
            $listing->delete();
            return redirect()->route('admin.listings.index')->with('success', 'Listing deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete listing.');
        }
    }
}