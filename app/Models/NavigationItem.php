<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_cta' => 'boolean',
        'is_external' => 'boolean',
        'is_visible' => 'boolean',
    ];

    public function scopeForLocation($query, string $location)
    {
        return $query->where('location', $location)->where('is_visible', true)->orderBy('sort_order');
    }
}
