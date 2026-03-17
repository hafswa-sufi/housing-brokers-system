<form method="GET" action="{{ route('property.index') }}">
    <div class="filter-group">

        {{-- 1. Location Filter --}}
        <label for="location">Location</label>
        <input 
            type="text" 
            name="location" 
            id="location" 
            placeholder="e.g., Nairobi, Kileleshwa"
            value="{{ request('location') }}"
        >
    </div>

    <div class="filter-group">
        
        {{-- 2. Price Filters --}}
        <label for="min_price">Min Price</label>
        <input 
            type="number" 
            name="min_price" 
            id="min_price" 
            placeholder="Min Price"
            value="{{ request('min_price') }}"
            min="0"
            max="2000000"
        >

        <label for="max_price">Max Price</label>
        <input 
            type="number" 
            name="max_price" 
            id="max_price" 
            placeholder="Max Price"
            value="{{ request('max_price') }}"
            min="0"
            max="10000000"
        >
    </div>

    <div class="filter-group">
        
        {{-- 3. Bedrooms Filter --}}
        <label for="bedrooms_count">Min Bedrooms</label>
        <select name="bedrooms_count" id="bedrooms_count">
            <option value="">Any</option>
            {{-- Generate options for bedroom count --}}
            @foreach (range(1, 5) as $count)
                <option 
                    value="{{ $count }}"
                    {{ request('bedrooms_count') == $count ? 'selected' : '' }}
                >
                    {{ $count }}+
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit">Search & Filter</button>
    
    {{-- Add a button to clear filters --}}
    @if (count(request()->except('page')) > 0)
        <a href="{{ route('property.index') }}">Clear Filters</a>
    @endif
</form>