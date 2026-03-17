<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tenant_id',
        'listing_id',
        'status',
        'scheduled_date',
    ];

    /**
     * Automatically set default status to 'pending' when creating a booking
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->status)) {
                $booking->status = 'pending';
            }
        });
    }

    // --- RELATIONSHIPS ---
    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id', 'listing_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id', 'user_id');
    }

    // --- OPTIONAL STATUS HELPERS ---
    public function markAccepted() { $this->status = 'accepted'; return $this->save(); }
    public function markRejected() { $this->status = 'rejected'; return $this->save(); }
    public function markCompleted() { $this->status = 'completed'; return $this->save(); }
    public function cancel()        { $this->status = 'canceled'; return $this->save(); }
}
