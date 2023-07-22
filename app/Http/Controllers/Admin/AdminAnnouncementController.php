<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('tags')->get();
        return response()->json($announcements);
    }

    public function show(Announcement $announcement)
    {
        $announcement->load('tags');
        return response()->json($announcement);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'is_urgent' => 'required|boolean',
        'tag_ids' => 'required|array',
        'tags_ids.*' => 'exists:announcement_tags,id'
    ]);

    $announcement = Announcement::create($validated);
    $announcement->tags()->attach($validated['tag_ids']);

    return response()->json($announcement, 201);
}

public function update(Request $request, Announcement $announcement)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
        'is_urgent' => 'required|boolean',
        'tags' => 'required|array',
        'tags.*' => 'exists:announcement_tags,id'
    ]);

    $announcement->update($validated);
    $announcement->tags()->sync($validated['tags']);

    return response()->json($announcement);
}

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json(null, 204);
    }
}
