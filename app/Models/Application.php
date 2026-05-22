<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    protected $casts = [];

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
