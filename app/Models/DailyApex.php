<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyApex extends Model
{
    protected $table = 'daily_apex';

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->orderByDesc('published_at');
    }
}
