<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
