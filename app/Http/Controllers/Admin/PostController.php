<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Posts/Index', [
            'posts' => Post::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => null,
            'translations' => (object) [],
            'locales' => config('app.available_locales'),
        ]);
    }

    public function store(Request $request)
    {
        [$data, $translations] = $this->validatePost($request);

        $post = new Post($data);
        $post->setTranslations('mk', $translations);
        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    public function edit(Post $post)
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
            // Existing per-locale overrides, so the MK tab pre-fills.
            'translations' => (object) ($post->translations ?? []),
            'locales' => config('app.available_locales'),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        [$data, $translations] = $this->validatePost($request, $post);

        $post->fill($data);
        $post->setTranslations('mk', $translations);
        $post->save();

        return back()->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    /**
     * @return array{0: array<string,mixed>, 1: array<string,mixed>} [baseData, mkTranslations]
     */
    private function validatePost(Request $request, ?Post $post = null): array
    {
        // Derive a URL-safe slug from the title when none is provided, and
        // normalise any slug the user typed so it never breaks the URL.
        $slugSource = $request->filled('slug') ? $request->input('slug') : $request->input('title');
        $request->merge(['slug' => Str::slug((string) $slugSource)]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($post?->id)],
            'category' => 'required|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'featured_image' => 'nullable|string|max:500',
            'featured_image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'reading_time' => 'nullable|string|max:50',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            // Macedonian overrides — every field optional; blanks fall back to EN.
            'translations.mk.title' => 'nullable|string|max:255',
            'translations.mk.category' => 'nullable|string|max:100',
            'translations.mk.excerpt' => 'nullable|string|max:500',
            'translations.mk.body' => 'nullable|string',
            'translations.mk.featured_image_alt' => 'nullable|string|max:255',
            'translations.mk.meta_title' => 'nullable|string|max:255',
            'translations.mk.meta_description' => 'nullable|string|max:500',
            'translations.mk.reading_time' => 'nullable|string|max:50',
        ]);

        $mk = $validated['translations']['mk'] ?? [];
        unset($validated['translations']);

        // A post marked "Published" without an explicit date would never appear
        // on the journal (the published scope requires published_at), so default it.
        if (! empty($validated['is_published']) && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        return [$validated, $mk];
    }
}
