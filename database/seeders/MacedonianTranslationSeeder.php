<?php

namespace Database\Seeders;

use App\Models\DailyApex;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\Section;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

/**
 * Applies the Macedonian (mk) translations for all existing site content.
 *
 * The translated copy lives in database/seeders/translations/*.json (produced
 * from the live English content). Running this seeder is idempotent: it only
 * fills the `translations` bag on matched rows and never touches the English
 * source columns, so it is safe to re-run after adding new English content.
 *
 *   php artisan db:seed --class=Database\\Seeders\\MacedonianTranslationSeeder
 */
class MacedonianTranslationSeeder extends Seeder
{
    private string $dir;

    public function run(): void
    {
        $this->dir = __DIR__.'/translations';

        $this->seedPosts();
        $this->seedSections();
        $this->seedMisc();

        // Localised caches must be rebuilt after content changes.
        $this->flushLocaleCaches();

        $this->command?->info('Macedonian translations applied.');
    }

    private function seedPosts(): void
    {
        foreach ($this->load('posts.mk.json') as $row) {
            $post = Post::find($row['id'] ?? null);
            if (! $post) {
                continue;
            }

            $post->setTranslations('mk', $this->only($row, [
                'title', 'category', 'excerpt', 'body',
                'featured_image_alt', 'meta_title', 'meta_description', 'reading_time',
            ]))->save();
        }
    }

    private function seedSections(): void
    {
        foreach ($this->load('sections.mk.json') as $row) {
            // Sections are matched by page slug + section key — row ids drift
            // between environments (re-seeds, admin edits), these don't.
            $section = Section::whereHas('page', fn ($q) => $q->where('slug', $row['page'] ?? null))
                ->where('key', $row['key'] ?? null)
                ->first();
            if (! $section) {
                $this->command?->warn("Section not found: {$row['page']}/{$row['key']}");

                continue;
            }

            $values = $this->only($row, [
                'eyebrow', 'headline', 'subheadline', 'body', 'quote', 'cta_text', 'image_alt',
            ]);

            // Metadata arrives as a JSON string; store it as a decoded array so
            // the frontend receives the same shape as the English metadata.
            if (! empty($row['metadata'])) {
                $decoded = is_string($row['metadata']) ? json_decode($row['metadata'], true) : $row['metadata'];
                if (is_array($decoded)) {
                    $values['metadata'] = $decoded;
                }
            }

            $this->replaceTranslations($section, $values);
        }
    }

    private function seedMisc(): void
    {
        $misc = $this->load('misc.mk.json');

        foreach ($misc['daily_apex'] ?? [] as $row) {
            $item = DailyApex::find($row['id'] ?? null);
            $item?->setTranslations('mk', $this->only($row, ['headline', 'body', 'category']))->save();
        }

        // Nav items are matched by location + current English label; pages by
        // slug — both survive rows being recreated with fresh ids.
        foreach ($misc['nav'] ?? [] as $row) {
            $item = NavigationItem::where('location', $row['location'] ?? null)
                ->where('label', $row['match_label'] ?? null)
                ->first();
            if ($item) {
                $this->replaceTranslations($item, $this->only($row, ['label']));
            } else {
                $this->command?->warn("Nav item not found: {$row['location']}/{$row['match_label']}");
            }
        }

        foreach ($misc['pages'] ?? [] as $row) {
            $item = Page::where('slug', $row['slug'] ?? null)->first();
            $item?->setTranslations('mk', $this->only($row, ['title', 'meta_title', 'meta_description']))->save();
        }

        foreach ($misc['settings'] ?? [] as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            $setting?->setTranslations('mk', ['value' => $value])->save();
        }
    }

    /**
     * Replace (not merge) the model's mk bucket with the given values, so
     * stale fields from earlier runs never linger on the row.
     */
    private function replaceTranslations($model, array $values): void
    {
        $all = $model->translations ?? [];
        unset($all['mk']);
        $model->translations = $all;
        $model->setTranslations('mk', $values)->save();
    }

    /** Decode a translations JSON file, returning an array (or empty on miss). */
    private function load(string $file): array
    {
        $path = $this->dir.'/'.$file;

        if (! is_file($path)) {
            $this->command?->warn("Translation file missing: {$file}");

            return [];
        }

        return json_decode(file_get_contents($path), true) ?: [];
    }

    /** Pull just the given keys (present + non-null) from a row. */
    private function only(array $row, array $keys): array
    {
        $out = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $row) && $row[$key] !== null && $row[$key] !== '') {
                $out[$key] = $row[$key];
            }
        }

        return $out;
    }

    private function flushLocaleCaches(): void
    {
        foreach (array_keys(config('app.available_locales', ['en' => 'English'])) as $locale) {
            Cache::forget("nav_items_{$locale}");
            Cache::forget("site_settings_{$locale}");
            Cache::forget("ui_translations_{$locale}");
        }
    }
}
