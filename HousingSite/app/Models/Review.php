<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $table = 'review';
    protected $fillable = [
        'agent_id',
        'listing_id',
        'tenant_id',
        'rating',
        'comment',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }
    public function agent()
    {
    return $this->belongsTo(Agent::class, 'agent_id');
    }
}
