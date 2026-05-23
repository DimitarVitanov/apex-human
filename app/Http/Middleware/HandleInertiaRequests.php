<?php

namespace App\Http\Middleware;

use App\Models\NavigationItem;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => fn () => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'is_admin' => $request->user()->is_admin,
                ] : null,
            ],
            'navigation' => fn () => Cache::remember('nav_items', 3600, fn () => [
                'header' => NavigationItem::forLocation('header')->get()->toArray(),
                'footer' => NavigationItem::forLocation('footer')->get()->toArray(),
            ]),
            'settings' => fn () => Cache::remember('site_settings', 3600, fn () => SiteSetting::all()->pluck('value', 'key')->toArray()),
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
                'booking_token' => $request->session()->get('booking_token'),
            ],
        ]);
    }
}
