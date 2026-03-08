<?php

namespace Modules\ForumTemplate\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ForumTemplate\App\Models\ForumTemplate;

class ForumTemplateController extends Controller
{
    public function index()
    {
        $forumTemplates = ForumTemplate::with(['author', 'forum'])->paginate(15);
        return view('forumtemplate::index', compact('forumTemplates'));
    }

    public function create()
    {
        $users = \Modules\User\App\Models\User::all();
        $forums = \Modules\Cms\App\Models\Forum::all();
        return view('forumtemplate::create', compact('users', 'forums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'forum_id' => 'required|exists:forums,id',
            'is_active' => 'boolean',
        ]);

        ForumTemplate::create($request->all());

        return redirect()->route('forum-template.index')->with('success', 'Forum template created successfully.');
    }

    public function show(ForumTemplate $forumTemplate)
    {
        $forumTemplate->load(['author', 'forum']);
        return view('forumtemplate::show', compact('forumTemplate'));
    }

    public function edit(ForumTemplate $forumTemplate)
    {
        $forumTemplate->load(['author', 'forum']);
        $users = \Modules\User\App\Models\User::all();
        $forums = \Modules\Cms\App\Models\Forum::all();
        return view('forumtemplate::edit', compact('forumTemplate', 'users', 'forums'));
    }

    public function update(Request $request, ForumTemplate $forumTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'author_id' => 'required|exists:users,id',
            'forum_id' => 'required|exists:forums,id',
            'is_active' => 'boolean',
        ]);

        $forumTemplate->update($request->all());

        return redirect()->route('forum-template.index')->with('success', 'Forum template updated successfully.');
    }

    public function destroy(ForumTemplate $forumTemplate)
    {
        $forumTemplate->delete();

        return redirect()->route('forum-template.index')->with('success', 'Forum template deleted successfully.');
    }
}