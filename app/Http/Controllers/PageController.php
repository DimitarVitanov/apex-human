<?php

namespace App\Http\Controllers;

use App\Models\DailyApex;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        $page = Cache::remember('page_home', 3600, fn () => Page::where('slug', 'home')->with('visibleSections')->firstOrFail());

        return Inertia::render('Home', [
            'page' => $page,
            'sections' => $page->visibleSections->keyBy('key'),
            'latestPosts' => Cache::remember('latest_posts', 3600, fn () => Post::published()->take(3)->get()),
            'latestDailyApex' => Cache::remember('latest_daily_apex', 3600, fn () => DailyApex::published()->take(5)->get()),
        ]);
    }

    public function about()
    {
        $page = Cache::remember('page_about', 3600, fn () => Page::where('slug', 'about')->with('visibleSections')->firstOrFail());

        return Inertia::render('About', [
            'page' => $page,
            'sections' => $page->visibleSections->keyBy('key'),
        ]);
    }

    public function method()
    {
        $page = Cache::remember('page_method', 3600, fn () => Page::where('slug', 'method')->with('visibleSections')->firstOrFail());

        return Inertia::render('Method', [
            'page' => $page,
            'sections' => $page->visibleSections->keyBy('key'),
        ]);
    }

    public function apply()
    {
        $page = Cache::remember('page_apply', 3600, fn () => Page::where('slug', 'apply')->with('visibleSections')->firstOrFail());

        return Inertia::render('Apply', [
            'page' => $page,
            'sections' => $page->visibleSections->keyBy('key'),
        ]);
    }

    public function journal()
    {
        $page = Page::where('slug', 'journal')->with('visibleSections')->firstOrFail();
        $posts = Post::published()->paginate(9);

        return Inertia::render('Journal', [
            'page' => $page,
            'sections' => $page->visibleSections->keyBy('key'),
            'posts' => $posts,
        ]);
    }

    public function journalShow(string $slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = Post::published()->where('id', '!=', $post->id)->take(3)->get();

        return Inertia::render('JournalArticle', [
            'post' => $post,
            'related' => $related,
        ]);
    }

    public function dailyApex()
    {
        $page = Page::where('slug', 'daily-apex')->with('visibleSections')->firstOrFail();
        $posts = DailyApex::published()->paginate(20);

        return Inertia::render('DailyApex', [
            'page' => $page,
            'sections' => $page->visibleSections->keyBy('key'),
            'posts' => $posts,
        ]);
    }

    public function contact()
    {
        $page = Cache::remember('page_contact', 3600, fn () => Page::where('slug', 'contact')->with('visibleSections')->firstOrFail());

        return Inertia::render('Contact', [
            'page' => $page,
            'sections' => $page->visibleSections->keyBy('key'),
        ]);
    }

    public function privacyPolicy()
    {
        return Inertia::render('PrivacyPolicy');
    }

    public function termsOfService()
    {
        return Inertia::render('TermsOfService');
    }
}
