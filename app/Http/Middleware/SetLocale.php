<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the request locale for the public site.
 *
 * Priority:
 *   1. An explicit visitor choice (the `locale` cookie set by the language
 *      switcher) always wins.
 *   2. Otherwise we geolocate the visitor: those browsing from Macedonia get
 *      Macedonian ('mk'), everyone else gets English ('en').
 *
 * Admin, auth and other back-office areas are always served in the base
 * (English) language so content can be edited against its source columns.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $available = array_keys(config('app.available_locales', ['en' => 'English']));
        $base = config('app.fallback_locale', 'en');

        // Back-office is always edited in the base language.
        if ($this->isBackOffice($request)) {
            App::setLocale($base);

            return $next($request);
        }

        $cookie = $request->cookie('locale');
        if ($cookie && in_array($cookie, $available, true)) {
            App::setLocale($cookie);

            return $next($request);
        }

        $locale = $this->geolocate($request) === 'mk' ? 'mk' : $base;
        $locale = in_array($locale, $available, true) ? $locale : $base;

        App::setLocale($locale);

        return $next($request);
    }

    private function isBackOffice(Request $request): bool
    {
        return $request->is('admin', 'admin/*', 'login', 'logout');
    }

    /** Returns 'mk' when the visitor appears to be in Macedonia, else 'en'. */
    private function geolocate(Request $request): string
    {
        $mkCountries = (array) config('app.mk_countries', ['MK']);

        $country = $this->countryCode($request);

        if ($country !== null) {
            return in_array(strtoupper($country), $mkCountries, true) ? 'mk' : 'en';
        }

        return 'en';
    }

    /**
     * Best-effort ISO country code for the request. Prefers CDN/proxy headers
     * (zero cost, present on Cloudflare / many hosts); optionally falls back to
     * a cached IP lookup when APP_GEOIP_LOOKUP is enabled.
     */
    private function countryCode(Request $request): ?string
    {
        $headerCandidates = [
            'CF-IPCountry',            // Cloudflare
            'X-Country-Code',
            'X-AppEngine-Country',     // Google
            'X-Geo-Country',
        ];

        foreach ($headerCandidates as $header) {
            $value = $request->header($header);
            if ($value && strtoupper($value) !== 'XX') {
                return $value;
            }
        }

        if (! config('app.geoip_lookup', env('APP_GEOIP_LOOKUP', false))) {
            return null;
        }

        $ip = $request->ip();
        if (! $ip || $ip === '127.0.0.1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return null;
        }

        return Cache::remember("geoip_country_$ip", now()->addDay(), function () use ($ip) {
            try {
                $response = Http::timeout(2)->get("https://ipapi.co/{$ip}/country/");
                if ($response->successful()) {
                    return trim($response->body()) ?: null;
                }
            } catch (\Throwable $e) {
                // Network issues must never break the page — just fall back to en.
            }

            return null;
        });
    }
}
