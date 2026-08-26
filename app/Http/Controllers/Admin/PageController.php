<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Pages/Index', [
            'pages' => Page::with('sections')->orderBy('sort_order')->get(),
        ]);
    }

    public function edit(Page $page)
    {
        $page->load('sections');

        // Admin runs in the base (English) locale, so serialised models expose
        // the source columns; re-attach the raw per-locale overrides so the
        // Macedonian tab can pre-fill.
        $pageData = array_merge($page->toArray(), ['translations' => $page->translations ?? []]);
        $pageData['sections'] = $page->sections->map(fn ($section) => array_merge(
            $section->toArray(),
            ['translations' => $section->translations ?? []],
        ))->all();

        return Inertia::render('Admin/Pages/Edit', [
            'page' => $pageData,
            'locales' => config('app.available_locales'),
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'translations.mk.title' => 'nullable|string|max:255',
            'translations.mk.meta_title' => 'nullable|string|max:255',
            'translations.mk.meta_description' => 'nullable|string|max:500',
        ]);

        $page->fill($request->only('title', 'meta_title', 'meta_description', 'is_published'));
        $page->setTranslations('mk', $request->input('translations.mk', []));
        $page->save();

        Cache::forget('page_' . $page->slug);

        return back()->with('success', 'Page updated.');
    }
}
