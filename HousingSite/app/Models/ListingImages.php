<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingImages extends Model
{
    use HasFactory;

    protected $primaryKey = 'image_id';
    
    public $timestamps = true;

    protected $fillable = [
        'listing_id',
        'image_url',
        'is_primary',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id', 'listing_id');
    }
}