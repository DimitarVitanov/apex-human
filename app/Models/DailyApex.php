<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class DailyApex extends Model
{
    use HasTranslations;

    protected $table = 'daily_apex';

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected array $translatable = ['headline', 'body', 'category'];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->orderByDesc('published_at');
    }
}
