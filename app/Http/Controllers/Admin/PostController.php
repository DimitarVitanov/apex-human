<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
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
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);
        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    public function edit(Post $post)
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validatePost($request);
        $post->update($data);

        return back()->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
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
        ]);
    }
}
