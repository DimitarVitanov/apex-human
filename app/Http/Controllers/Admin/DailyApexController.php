<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyApex;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DailyApexController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/DailyApex/Index', [
            'posts' => DailyApex::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/DailyApex/Edit', [
            'post' => null,
            'translations' => (object) [],
            'locales' => config('app.available_locales'),
        ]);
    }

    public function store(Request $request)
    {
        [$data, $mk] = $this->validatePost($request);

        $item = new DailyApex($data);
        $item->setTranslations('mk', $mk);
        $item->save();

        return redirect()->route('admin.daily-apex.index')->with('success', 'Daily Apex created.');
    }

    public function edit(DailyApex $daily_apex)
    {
        return Inertia::render('Admin/DailyApex/Edit', [
            'post' => $daily_apex,
            'translations' => (object) ($daily_apex->translations ?? []),
            'locales' => config('app.available_locales'),
        ]);
    }

    public function update(Request $request, DailyApex $daily_apex)
    {
        [$data, $mk] = $this->validatePost($request);

        $daily_apex->fill($data);
        $daily_apex->setTranslations('mk', $mk);
        $daily_apex->save();

        return back()->with('success', 'Daily Apex updated.');
    }

    public function destroy(DailyApex $daily_apex)
    {
        $daily_apex->delete();

        return redirect()->route('admin.daily-apex.index')->with('success', 'Daily Apex deleted.');
    }

    /**
     * @return array{0: array<string,mixed>, 1: array<string,mixed>}
     */
    private function validatePost(Request $request): array
    {
        $validated = $request->validate([
            'headline' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'translations.mk.headline' => 'nullable|string|max:255',
            'translations.mk.body' => 'nullable|string',
            'translations.mk.category' => 'nullable|string|max:100',
        ]);

        $mk = $validated['translations']['mk'] ?? [];
        unset($validated['translations']);

        return [$validated, $mk];
    }
}
