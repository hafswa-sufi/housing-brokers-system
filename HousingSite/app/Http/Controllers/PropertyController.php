<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing; 
use App\Models\ListingImages;
use App\Models\Bookings; // ✅ Import Bookings Model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    // ... [Keep publicIndex, show, manage, index, create, store, edit, update, destroy methods as they were] ...

    public function publicIndex(Request $request)
    {
        $query = Listing::query()
                        ->where('status', 'available')
                        ->where('verification_status', 'verified');
        
        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        if ($request->filled('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('bedrooms_count') && is_numeric($request->bedrooms_count)) {
            $query->where('bedrooms', '>=', $request->bedrooms_count); 
        }

        $listings = $query->with(['agent.user', 'images'])->latest()->paginate(12)->withQueryString(); 
        return view('listings.index', ['listings' => $listings, 'filters' => $request->all()]);
    }

    public function show($id)
    {
        $listing = Listing::with(['agent.user', 'images'])->where('listing_id', $id)->firstOrFail();
        
        // Allow owner or admin to see non-available listings
        $isOwner = Auth::check() && Auth::user()->agent && Auth::user()->agent->agent_id == $listing->agent_id;
        $isAdmin = Auth::check() && Auth::user()->role === 'admin'; 

        if ($listing->status !== 'available' && !$isOwner && !$isAdmin) {
            abort(404);
        }

        return view('listings.show', compact('listing'));
    }

    public function manage() { return $this->index(); }

    public function index()
    {
        if (!Auth::check()) return redirect()->route('login.form');
        $agent = Auth::user()->agent;
        if (!$agent) return redirect()->route('agent.register');

        $listings = Listing::where('agent_id', $agent->agent_id)->with('images')->latest()->paginate(10);
        return view('dashboard.agent.listings.index', compact('listings'));
    }

    public function create()
    {
        if (!Auth::check()) return redirect()->route('login.form');
        $agent = Auth::user()->agent;
        if (!$agent || $agent->verification_status !== 'verified') {
            return redirect()->route('agent.dashboard')->with('error', 'Verification required.');
        }
        return view('dashboard.agent.listings.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login.form');
        $agent = Auth::user()->agent;
        if (!$agent || $agent->verification_status !== 'verified') return redirect()->back()->with('error', 'Unauthorized.');

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:100',
            'status' => ['required', Rule::in(['available', 'rented', 'removed', 'flagged'])],
            'location' => 'required|string|max:255',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'square_feet' => 'nullable|integer|min:0',
            'property_type' => 'required|string',
            'description' => 'required|string|min:20',
            'images' => 'required|array|max:5', 
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $listing = Listing::create([
                'agent_id' => $agent->agent_id,
                'title' => $validatedData['title'],
                'price' => $validatedData['price'],
                'status' => $validatedData['status'],
                'location' => $validatedData['location'],
                'bedrooms' => $validatedData['bedrooms'],
                'bathrooms' => $validatedData['bathrooms'],
                'size' => $validatedData['square_feet'] ?? 0,
                'description' => $validatedData['description'],
                'property_type' => $validatedData['property_type'],
                'verification_status' => 'pending',
                'garage' => false,
            ]);

            if ($request->hasFile('images')) {
                $isMain = true;
                foreach ($request->file('images') as $image) {
                    $path = $image->store('listing_images', 'public');
                    ListingImages::create(['listing_id' => $listing->listing_id, 'image_url' => $path, 'is_primary' => $isMain ? 1 : 0]);
                    $isMain = false;
                }
            }
            DB::commit();
            return redirect()->route('agent.listings.index')->with('success', 'Property posted!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        if (!Auth::check()) return redirect()->route('login.form');
        $agent = Auth::user()->agent;
        $listing = Listing::where('listing_id', $id)->where('agent_id', $agent->agent_id)->with('images')->firstOrFail();
        return view('dashboard.agent.listings.edit', compact('listing'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) return redirect()->route('login.form');
        $agent = Auth::user()->agent;
        $listing = Listing::where('listing_id', $id)->where('agent_id', $agent->agent_id)->firstOrFail();

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:100',
            'status' => ['required', Rule::in(['available', 'rented', 'removed', 'flagged'])],
            'location' => 'required|string|max:255',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'square_feet' => 'nullable|integer|min:0',
            'property_type' => 'required|string',
            'description' => 'required|string|min:20',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'remove_images' => 'nullable|array'
        ]);

        DB::beginTransaction();
        try {
            $listing->update([
                'title' => $validatedData['title'],
                'price' => $validatedData['price'],
                'status' => $validatedData['status'],
                'location' => $validatedData['location'],
                'bedrooms' => $validatedData['bedrooms'],
                'bathrooms' => $validatedData['bathrooms'],
                'size' => $validatedData['square_feet'] ?? $listing->size,
                'description' => $validatedData['description'],
                'property_type' => $validatedData['property_type'],
            ]);

            if ($request->has('remove_images')) {
                $imagesToDelete = ListingImages::whereIn('image_id', $request->remove_images)
                                               ->where('listing_id', $listing->listing_id)
                                               ->get();
                foreach ($imagesToDelete as $img) {
                    if (Storage::disk('public')->exists($img->image_url)) {
                        Storage::disk('public')->delete($img->image_url);
                    }
                    $img->delete();
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('listing_images', 'public');
                    ListingImages::create(['listing_id' => $listing->listing_id, 'image_url' => $path, 'is_primary' => 0]);
                }
            }

            DB::commit();
            return redirect()->route('agent.listings.index')->with('success', 'Property updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (!Auth::check()) return redirect()->route('login.form');
        $agent = Auth::user()->agent;
        $listing = Listing::where('listing_id', $id)->where('agent_id', $agent->agent_id)->firstOrFail();

        DB::beginTransaction();
        try {
            foreach ($listing->images as $image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }
            $listing->delete();
            DB::commit();
            return redirect()->route('agent.listings.index')->with('success', 'Property deleted!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Deletion failed.');
        }
    }

    public function scheduleViewing($id)
    {
        // ✅ FIX: Use listing_id
        $listing = Listing::with('agent.user')->where('listing_id', $id)->firstOrFail();
        return view('properties.schedule_viewing', compact('listing'));
    }

    public function submitScheduleViewing(Request $request, $id)
    {
        // ✅ FIX: Use listing_id
        $listing = Listing::where('listing_id', $id)->firstOrFail();

        $validated = $request->validate([
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required',
            'message' => 'nullable|string|max:500',
        ]);

        // ✅ FIX: Actually create the booking in the database
        try {
            Bookings::create([
                'tenant_id' => Auth::id(),
                'listing_id' => $listing->listing_id,
                'scheduled_date' => $validated['preferred_date'] . ' ' . $validated['preferred_time'],
                'status' => 'pending',
                // If you have a 'message' column in bookings table, add it here:
                // 'message' => $validated['message'] 
            ]);

            return redirect()->route('properties.show', $listing->listing_id)
                             ->with('success', 'Your viewing request has been submitted! You can track it in your dashboard.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to schedule viewing: ' . $e->getMessage());
        }
    }
}