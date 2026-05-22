<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function slot()
    {
        return $this->belongsTo(AvailableSlot::class, 'available_slot_id');
    }
}
