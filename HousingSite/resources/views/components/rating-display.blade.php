<!-- resources/views/components/rating-display.blade.php -->

@php
    $avgRating = $agent->reviews->avg('rating') ?? 0;
    $totalReviews = $agent->reviews->count() ?? 0;
@endphp

<div class="rating-summary mb-3">
    <div>
        <strong>Average Rating:</strong> {{ number_format($avgRating, 1) }} / 5
        <div class="star-rating-display">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fas fa-star{{ $i <= round($avgRating) ? '' : '-o' }}"></i>
            @endfor
        </div>
        <small>({{ $totalReviews }} review{{ $totalReviews == 1 ? '' : 's' }})</small>
    </div>
</div>

<div class="reviews-list">
    @forelse ($agent->reviews as $review)
        <div class="review mb-3 p-3 border rounded">
            <div class="star-rating-display mb-1">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                @endfor
            </div>
            <p>{{ $review->comment }}</p>
            <small class="text-muted">Reviewed by {{ $review->tenant->name ?? 'Anonymous' }} on {{ $review->created_at->format('M d, Y') }}</small>
        </div>
    @empty
        <p>No reviews yet.</p>
    @endforelse
</div>

<style>
    .star-rating-display i {
        color: #ffc107; /* gold */
        margin-right: 2px;
    }
    .star-rating-display i.fa-star-o {
        color: #ddd;
    }
</style>
