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
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);
        DailyApex::create($data);

        return redirect()->route('admin.daily-apex.index')->with('success', 'Daily Apex created.');
    }

    public function edit(DailyApex $daily_apex)
    {
        return Inertia::render('Admin/DailyApex/Edit', [
            'post' => $daily_apex,
        ]);
    }

    public function update(Request $request, DailyApex $daily_apex)
    {
        $data = $this->validatePost($request);
        $daily_apex->update($data);

        return back()->with('success', 'Daily Apex updated.');
    }

    public function destroy(DailyApex $daily_apex)
    {
        $daily_apex->delete();

        return redirect()->route('admin.daily-apex.index')->with('success', 'Daily Apex deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'headline' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'nullable|string|max:100',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);
    }
}
