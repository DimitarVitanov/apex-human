<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /** Page-level SEO copy is translatable (the slug/URL stays constant). */
    protected array $translatable = [
        'title', 'meta_title', 'meta_description',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    public function visibleSections(): HasMany
    {
        return $this->hasMany(Section::class)->where('is_visible', true)->orderBy('sort_order');
    }

    public function section(string $key): ?Section
    {
        return $this->sections()->where('key', $key)->first();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }
}
