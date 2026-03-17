<!-- resources/views/components/review-form.blade.php -->

<form action="{{ route('reviews.store') }}" method="POST">
    @csrf
    
    <input type="hidden" name="agent_id" value="{{ $agent->agent_id ?? '' }}">

    <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <div class="star-rating">
            @for ($i = 1; $i <= 5; $i++)
                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required />
                <label for="star{{ $i }}" title="{{ $i }} stars">
                    <i class="fas fa-star"></i>
                </label>
            @endfor
        </div>
        @error('rating')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="comment" class="form-label">Review</label>
        <textarea name="comment" id="comment" rows="4" class="form-control" required>{{ old('comment') }}</textarea>
        @error('comment')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Submit Review</button>

</form>

<style>
    .star-rating {
        direction: rtl;
        font-size: 1.5rem;
        unicode-bidi: bidi-override;
        display: inline-flex;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
    }

    .star-rating input[type="radio"]:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107; /* gold */
    }
</style>
