<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'is_blocked' => 'boolean',
    ];

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    public function isBooked(): bool
    {
        return $this->booking()->exists();
    }
}
