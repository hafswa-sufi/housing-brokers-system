<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $primaryKey = 'agent_id';
    public $timestamps = true;

   protected $fillable = [
        'user_id',
        'verification_status',
        'id_document_url',
        'license_number', 
        'bio',
        'rating_avg',
        // Add these for agent registration form
        'id_number',
        'kra_pin',
        'company_name',
        'business_reg_number', 
        'business_address',
        'experience',
        'selfie_id_path',
    ];

    // CORRECT User relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); // ✅ CORRECT
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'agent_id', 'agent_id');
    }

    public function blacklist()
    {
        return $this->hasOne(Blacklist::class, 'agent_id', 'agent_id');
    }

    public function Reviews()
    {
        return $this->hasManyThrough(Review::class, Listing::class, 'agent_id', 'listing_id');
    }
    
}