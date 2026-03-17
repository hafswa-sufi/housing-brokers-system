<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $primaryKey = 'listing_id';
    
    public $incrementing = true;

    protected $fillable = [
        'agent_id',
        'title',
        'description',
        'price',
        'location',
        'bedrooms',
        'bathrooms',
        'property_type',
        'size',
        'garage',
        'status',
        'verification_status',
    ];

    // Relationships
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'agent_id');
    }

    public function images()
    {
        return $this->hasMany(ListingImages::class, 'listing_id', 'listing_id');
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'listing_id', 'listing_id');
    }
}