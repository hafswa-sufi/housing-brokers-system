@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">

    <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
        <!-- Agent Header -->
        <div class="p-8 md:p-12 border-b bg-gradient-to-r from-blue-50 to-blue-100 flex flex-col md:flex-row items-start md:items-center justify-between">
            <div class="flex items-center space-x-6">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-blue-500 flex items-center justify-center text-white text-3xl font-extrabold shadow-lg">
                    {{ substr($agent->user->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900">{{ $agent->user->name }}</h1>
                    <p class="text-lg text-gray-600 mt-1">
                        Real Estate Agent
                        @if($agent->verification_status === 'verified')
                            <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Verified
                            </span>
                        @endif
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Member Since: {{ $agent->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Agent Info -->
        <div class="p-8 md:p-12 space-y-12">
            <!-- About & Contact -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">About {{ $agent->user->name }}</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $agent->bio ?? 'No biography provided yet.' }}</p>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Contact</h2>
                    <ul class="text-gray-700 space-y-2">
                        <li><strong>Email:</strong> {{ $agent->user->email }}</li>
                        <li><strong>Phone:</strong> {{ $agent->user->phone ?? 'N/A' }}</li>
                    </ul>
                </div>
            </section>

            <!-- Listings -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Active Listings ({{ $listings->count() }})</h2>
                @if($listings->isEmpty())
                    <p class="text-gray-600">This agent currently has no active property listings.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($listings as $listing)
                            <div class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300">
                                <a href="{{ route('properties.show', $listing->listing_id) }}">
                                    <div class="h-52 w-full rounded-t-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                                        <img src="https://placehold.co/400x300/e0f2f1/004d40?text=Property" alt="Property Image" class="w-full h-full object-cover">
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold text-gray-900 truncate">{{ $listing->title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $listing->location }}</p>
                                        <p class="text-xl font-extrabold text-blue-600 mt-2">KSh {{ number_format($listing->price) }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Reviews -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Reviews</h2>
                
                <div class="space-y-6 mb-8">
                    @if ($reviews->isEmpty())
                        <p class="text-gray-600">Be the first to leave a review for this agent.</p>
                    @else
                        @foreach ($reviews as $review)
                            <div class="border p-5 rounded-xl bg-gray-50 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-bold text-gray-800">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                    <span class="text-yellow-400">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $review->rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </span>
                                </div>
                                <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                                <p class="text-xs text-gray-500 mt-1">Reviewed on: {{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Review Form -->
                @auth
                    @if(Auth::user()->role === 'tenant')
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Leave a Review</h3>
                        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-xl shadow-lg border">
                            @csrf
                            <input type="hidden" name="agent_id" value="{{ $agent->agent_id }}">

                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                                <select name="rating" id="rating" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg">
                                    <option value="">Select a rating</option>
                                    <option value="5">5 Stars - Excellent</option>
                                    <option value="4">4 Stars - Good</option>
                                    <option value="3">3 Stars - Average</option>
                                    <option value="2">2 Stars - Fair</option>
                                    <option value="1">1 Star - Poor</option>
                                </select>
                                @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="comment" class="block text-sm font-medium text-gray-700">Your Review</label>
                                <textarea name="comment" id="comment" rows="4" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-3" placeholder="Share your experience..."></textarea>
                                @error('comment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                Submit Review
                            </button>
                        </form>
                    @endif
                @else
                    <p class="text-center p-4 border rounded-lg bg-yellow-50 text-yellow-800">
                        Please <a href="{{ route('login.form') }}" class="font-bold underline">log in</a> to submit a review.
                    </p>
                @endauth
            </section>
        </div>
    </div>
</div>
@endsection
