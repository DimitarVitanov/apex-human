<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasTranslations;

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
        'is_visible' => 'boolean',
    ];

    /** Section text (and its structured metadata) is fully translatable. */
    protected array $translatable = [
        'eyebrow', 'headline', 'subheadline', 'body',
        'quote', 'cta_text', 'image_alt', 'metadata',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
