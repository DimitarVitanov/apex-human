<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class NavigationController extends Controller
{
    public function index()
    {
        $map = fn ($location) => NavigationItem::where('location', $location)
            ->orderBy('sort_order')->get()
            ->map(fn (NavigationItem $item) => array_merge(
                $item->getRawOriginal(),
                ['label_mk' => data_get($item->translations, 'mk.label')],
            ));

        return Inertia::render('Admin/Navigation/Index', [
            'headerItems' => $map('header'),
            'footerItems' => $map('footer'),
            'locales' => config('app.available_locales'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'location' => 'required|in:header,footer',
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'is_cta' => 'boolean',
            'is_external' => 'boolean',
            'sort_order' => 'integer',
            'translations.mk.label' => 'nullable|string|max:255',
        ]);

        $mk = $data['translations']['mk'] ?? [];
        unset($data['translations']);

        $item = new NavigationItem($data);
        $item->setTranslations('mk', $mk);
        $item->save();

        $this->flushNavCache();

        return back()->with('success', 'Navigation item added.');
    }

    public function update(Request $request, NavigationItem $navigation)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'is_cta' => 'boolean',
            'is_external' => 'boolean',
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
            'translations.mk.label' => 'nullable|string|max:255',
        ]);

        $mk = $data['translations']['mk'] ?? [];
        unset($data['translations']);

        $navigation->fill($data);
        $navigation->setTranslations('mk', $mk);
        $navigation->save();

        $this->flushNavCache();

        return back()->with('success', 'Navigation item updated.');
    }

    public function destroy(NavigationItem $navigation)
    {
        $navigation->delete();

        $this->flushNavCache();

        return back()->with('success', 'Navigation item deleted.');
    }

    /** Navigation is cached per locale; clear every language's copy. */
    private function flushNavCache(): void
    {
        foreach (array_keys(config('app.available_locales', ['en' => 'English'])) as $locale) {
            Cache::forget("nav_items_{$locale}");
        }
    }
}
