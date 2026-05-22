<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Contact;
use App\Models\DailyApex;
use App\Models\Post;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'applications' => Application::count(),
                'pending_applications' => Application::where('status', 'pending')->count(),
                'contacts' => Contact::where('is_read', false)->count(),
                'posts' => Post::count(),
                'daily_apex' => DailyApex::count(),
            ],
            'recent_applications' => Application::latest()->take(5)->get(),
            'recent_contacts' => Contact::where('is_read', false)->latest()->take(5)->get(),
        ]);
    }
}
