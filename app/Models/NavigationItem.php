<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected $casts = [
        'is_cta' => 'boolean',
        'is_external' => 'boolean',
        'is_visible' => 'boolean',
    ];

    protected array $translatable = ['label'];

    public function scopeForLocation($query, string $location)
    {
        return $query->where('location', $location)->where('is_visible', true)->orderBy('sort_order');
    }
}
