<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    /**
     * Persist the visitor's language choice for a year and send them back to
     * the page they came from. This choice overrides geolocation on future
     * requests (see App\Http\Middleware\SetLocale).
     */
    public function switch(Request $request, string $locale)
    {
        $available = array_keys(config('app.available_locales', ['en' => 'English']));

        if (! in_array($locale, $available, true)) {
            $locale = config('app.fallback_locale', 'en');
        }

        $back = $request->headers->get('referer') ?: '/';

        return redirect($back)->withCookie(
            Cookie::make('locale', $locale, 60 * 24 * 365)
        );
    }
}
