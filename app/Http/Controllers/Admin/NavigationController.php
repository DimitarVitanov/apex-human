<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NavigationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Navigation/Index', [
            'headerItems' => NavigationItem::where('location', 'header')->orderBy('sort_order')->get(),
            'footerItems' => NavigationItem::where('location', 'footer')->orderBy('sort_order')->get(),
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
        ]);

        NavigationItem::create($data);

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
        ]);

        $navigation->update($data);

        return back()->with('success', 'Navigation item updated.');
    }

    public function destroy(NavigationItem $navigation)
    {
        $navigation->delete();

        return back()->with('success', 'Navigation item deleted.');
    }
}
