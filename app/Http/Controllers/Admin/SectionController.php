<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SectionController extends Controller
{
    public function update(Request $request, Section $section)
    {
        $request->validate([
            'eyebrow' => 'nullable|string|max:255',
            'headline' => 'nullable|string|max:500',
            'subheadline' => 'nullable|string|max:1000',
            'body' => 'nullable|string',
            'quote' => 'nullable|string|max:1000',
            'cta_text' => 'nullable|string|max:255',
            'cta_url' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'image_alt' => 'nullable|string|max:255',
            'metadata' => 'nullable|json',
            'is_visible' => 'boolean',
            // Macedonian overrides (metadata as a JSON string, decoded below).
            'translations.mk.eyebrow' => 'nullable|string|max:255',
            'translations.mk.headline' => 'nullable|string|max:500',
            'translations.mk.subheadline' => 'nullable|string|max:1000',
            'translations.mk.body' => 'nullable|string',
            'translations.mk.quote' => 'nullable|string|max:1000',
            'translations.mk.cta_text' => 'nullable|string|max:255',
            'translations.mk.image_alt' => 'nullable|string|max:255',
            'translations.mk.metadata' => 'nullable|json',
        ]);

        $data = $request->only([
            'eyebrow', 'headline', 'subheadline', 'body', 'quote',
            'cta_text', 'cta_url', 'image', 'image_alt', 'is_visible',
        ]);

        if ($request->has('metadata')) {
            $data['metadata'] = json_decode($request->metadata, true);
        }

        $section->fill($data);

        // Macedonian: same field set (plus decoded metadata array).
        $mk = $request->input('translations.mk', []);
        if (isset($mk['metadata']) && is_string($mk['metadata'])) {
            $mk['metadata'] = json_decode($mk['metadata'], true);
        }
        $section->setTranslations('mk', $mk);
        $section->save();

        Cache::forget('page_' . $section->page->slug);

        return back()->with('success', 'Section updated.');
    }
}
