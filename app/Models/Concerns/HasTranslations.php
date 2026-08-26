<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\App;

/**
 * Gives a model per-locale content without extra columns per field.
 *
 * The base table columns hold the source language (English). A single
 * `translations` JSON column holds overrides keyed by locale, e.g.
 *
 *   { "mk": { "title": "…", "body": "…", "metadata": { … } } }
 *
 * When the active app locale is not the base locale and a non-empty override
 * exists for a translatable field, that override is transparently swapped in
 * wherever the model is serialised (Inertia props, API, etc.) or read via the
 * attribute accessor — so existing views keep using `$post->title` unchanged.
 *
 * Models using this trait must declare:
 *   protected array $translatable = ['title', 'body', ...];
 * and cast `translations` to array (handled here automatically).
 */
trait HasTranslations
{
    public static function bootHasTranslations(): void
    {
        // no-op; kept for clarity / future hooks
    }

    public function initializeHasTranslations(): void
    {
        $this->mergeCasts(['translations' => 'array']);
    }

    /** The base (source) language the plain columns are written in. */
    public function baseLocale(): string
    {
        return config('app.fallback_locale', 'en');
    }

    /** Fields that can carry a per-locale override. */
    public function translatableAttributes(): array
    {
        return $this->translatable ?? [];
    }

    /**
     * Localized value for a single translatable field, falling back to the
     * base column value when there is no override for the active locale.
     */
    public function translate(string $field, ?string $locale = null): mixed
    {
        $base = $this->getAttributeFromArray($field);

        $locale ??= App::getLocale();
        if ($locale === $this->baseLocale()) {
            return $this->castTranslatable($field, $base);
        }

        $override = data_get($this->translations, "$locale.$field");

        return $this->isFilled($override) ? $override : $this->castTranslatable($field, $base);
    }

    /**
     * Store one or more field overrides for a locale, merging with any
     * existing overrides. Passing an empty value clears that field's override.
     */
    public function setTranslations(string $locale, array $values): static
    {
        if ($locale === $this->baseLocale()) {
            return $this; // base language lives in the real columns
        }

        $all = $this->translations ?? [];
        $bucket = $all[$locale] ?? [];

        foreach ($values as $field => $value) {
            if (! in_array($field, $this->translatableAttributes(), true)) {
                continue;
            }
            if ($this->isFilled($value)) {
                $bucket[$field] = $value;
            } else {
                unset($bucket[$field]);
            }
        }

        if (empty($bucket)) {
            unset($all[$locale]);
        } else {
            $all[$locale] = $bucket;
        }

        $this->translations = $all;

        return $this;
    }

    /** Override attribute reads so `$model->title` returns the localized value. */
    public function getAttribute($key)
    {
        if ($key !== 'translations'
            && in_array($key, $this->translatableAttributes(), true)
            && App::getLocale() !== $this->baseLocale()) {
            return $this->translate($key);
        }

        return parent::getAttribute($key);
    }

    /** Localize translatable fields when the model is serialized. */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        if (App::getLocale() === $this->baseLocale()) {
            unset($attributes['translations']);

            return $attributes;
        }

        foreach ($this->translatableAttributes() as $field) {
            if (array_key_exists($field, $attributes)) {
                $attributes[$field] = $this->translate($field);
            }
        }

        // Never leak the raw translations bag to the frontend.
        unset($attributes['translations']);

        return $attributes;
    }

    private function isFilled(mixed $value): bool
    {
        if (is_array($value)) {
            return ! empty($value);
        }

        return $value !== null && $value !== '';
    }

    /** Apply the field's normal cast (e.g. json metadata) to the base value. */
    private function castTranslatable(string $field, mixed $value): mixed
    {
        if ($this->hasCast($field)) {
            return $this->castAttribute($field, $value);
        }

        return $value;
    }
}
