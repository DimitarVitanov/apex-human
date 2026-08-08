<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,webp,gif|max:5120',
            'collection' => 'nullable|string|max:100',
            'alt' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $collection = $request->input('collection', 'posts');

        // Stored on the public disk so it is served from /storage (requires storage:link).
        $path = $file->store($collection, 'public');

        $media = Media::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'alt' => $request->input('alt'),
            'collection' => $collection,
        ]);

        return response()->json([
            'id' => $media->id,
            'url' => $media->url,
            'path' => $media->path,
            'filename' => $media->filename,
        ]);
    }
}
