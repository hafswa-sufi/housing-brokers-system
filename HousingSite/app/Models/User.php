<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password_hash',  
        'role',
    ];
    
    protected $hidden = [
        'password_hash', // FIX: Change from 'password' to 'password_hash'
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships - CORRECTED
    public function agent()
    {
        return $this->hasOne(Agent::class, 'user_id', 'user_id'); // FIXED
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent' && $this->agent !== null;
    }

    public function isTenant(): bool
    {
        return $this->role === 'tenant';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'tenant_id'); // FIXED: Use singular Review
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'tenant_id'); // FIXED: Use singular Booking
    }

    public function reports()
    {
        return $this->hasMany(Reports::class, 'reported_by'); // FIXED: Use singular Report
    }

    // For agents to access their listings
    public function listings()
    {
        return $this->hasMany(Listing::class, 'agent_id', 'user_id'); // FIXED
    }
}