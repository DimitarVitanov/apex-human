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
        ]);

        $data = $request->only([
            'eyebrow', 'headline', 'subheadline', 'body', 'quote',
            'cta_text', 'cta_url', 'image', 'image_alt', 'is_visible',
        ]);

        if ($request->has('metadata')) {
            $data['metadata'] = json_decode($request->metadata, true);
        }

        $section->update($data);

        Cache::forget('page_' . $section->page->slug);

        return back()->with('success', 'Section updated.');
    }
}
