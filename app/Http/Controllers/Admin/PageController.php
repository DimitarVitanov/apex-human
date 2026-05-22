<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
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
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page->load('sections'),
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $page->update($request->only('title', 'meta_title', 'meta_description', 'is_published'));

        return back()->with('success', 'Page updated.');
    }
}
