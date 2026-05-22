<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return Inertia::render('Admin/Applications/Index', [
            'applications' => $query->paginate(20),
            'filters' => $request->only('status'),
        ]);
    }

    public function show(Application $application)
    {
        return Inertia::render('Admin/Applications/Show', [
            'application' => $application,
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $data = $request->only('status', 'admin_notes');

        if ($data['status'] === 'accepted' && !$application->booking_token) {
            $data['booking_token'] = bin2hex(random_bytes(32));
        }

        $application->update($data);

        return back()->with('success', 'Application updated.');
    }
}
