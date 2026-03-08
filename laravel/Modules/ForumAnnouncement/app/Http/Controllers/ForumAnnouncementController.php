<?php

namespace Modules\ForumAnnouncement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ForumAnnouncement\App\Models\ForumAnnouncement;

class ForumAnnouncementController extends Controller
{
    public function index()
    {
        $forumAnnouncements = ForumAnnouncement::with(['author', 'forum'])->paginate(15);
        return view('forumannouncement::index', compact('forumAnnouncements'));
    }

    public function create()
    {
        $users = \Modules\User\App\Models\User::all();
        $forums = \Modules\Cms\App\Models\Forum::all();
        return view('forumannouncement::create', compact('users', 'forums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'forum_id' => 'required|exists:forums,id',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        ForumAnnouncement::create($request->all());

        return redirect()->route('forum-announcement.index')->with('success', 'Forum announcement created successfully.');
    }

    public function show(ForumAnnouncement $forumAnnouncement)
    {
        $forumAnnouncement->load(['author', 'forum']);
        return view('forumannouncement::show', compact('forumAnnouncement'));
    }

    public function edit(ForumAnnouncement $forumAnnouncement)
    {
        $forumAnnouncement->load(['author', 'forum']);
        $users = \Modules\User\App\Models\User::all();
        $forums = \Modules\Cms\App\Models\Forum::all();
        return view('forumannouncement::edit', compact('forumAnnouncement', 'users', 'forums'));
    }

    public function update(Request $request, ForumAnnouncement $forumAnnouncement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'forum_id' => 'required|exists:forums,id',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        $forumAnnouncement->update($request->all());

        return redirect()->route('forum-announcement.index')->with('success', 'Forum announcement updated successfully.');
    }

    public function destroy(ForumAnnouncement $forumAnnouncement)
    {
        $forumAnnouncement->delete();

        return redirect()->route('forum-announcement.index')->with('success', 'Forum announcement deleted successfully.');
    }
}