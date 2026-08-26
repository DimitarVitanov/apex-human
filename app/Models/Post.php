<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /** Fields that can be authored in Macedonian as well as English. */
    protected array $translatable = [
        'title', 'category', 'excerpt', 'body',
        'featured_image_alt', 'meta_title', 'meta_description', 'reading_time',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->orderByDesc('published_at');
    }
}
