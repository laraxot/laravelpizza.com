<?php

namespace Modules\ForumPermission\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ForumPermission\App\Models\ForumPermission;

class ForumPermissionController extends Controller
{
    public function index()
    {
        $forumPermissions = ForumPermission::with(['forum', 'role'])->paginate(15);
        return view('forumpermission::index', compact('forumPermissions'));
    }

    public function create()
    {
        $forums = \Modules\Cms\App\Models\Forum::all();
        $roles = \Modules\User\App\Models\Role::all();
        return view('forumpermission::create', compact('forums', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'forum_id' => 'required|exists:forums,id',
            'role_id' => 'required|exists:roles,id',
            'can_create_post' => 'boolean',
            'can_edit_post' => 'boolean',
            'can_delete_post' => 'boolean',
            'can_create_thread' => 'boolean',
            'can_edit_thread' => 'boolean',
            'can_delete_thread' => 'boolean',
            'can_reply' => 'boolean',
            'can_edit_reply' => 'boolean',
            'can_delete_reply' => 'boolean',
            'can_moderate' => 'boolean',
        ]);

        ForumPermission::create($request->all());

        return redirect()->route('forum-permission.index')->with('success', 'Forum permission created successfully.');
    }

    public function show(ForumPermission $forumPermission)
    {
        $forumPermission->load(['forum', 'role']);
        return view('forumpermission::show', compact('forumPermission'));
    }

    public function edit(ForumPermission $forumPermission)
    {
        $forumPermission->load(['forum', 'role']);
        $forums = \Modules\Cms\App\Models\Forum::all();
        $roles = \Modules\User\App\Models\Role::all();
        return view('forumpermission::edit', compact('forumPermission', 'forums', 'roles'));
    }

    public function update(Request $request, ForumPermission $forumPermission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'forum_id' => 'required|exists:forums,id',
            'role_id' => 'required|exists:roles,id',
            'can_create_post' => 'boolean',
            'can_edit_post' => 'boolean',
            'can_delete_post' => 'boolean',
            'can_create_thread' => 'boolean',
            'can_edit_thread' => 'boolean',
            'can_delete_thread' => 'boolean',
            'can_reply' => 'boolean',
            'can_edit_reply' => 'boolean',
            'can_delete_reply' => 'boolean',
            'can_moderate' => 'boolean',
        ]);

        $forumPermission->update($request->all());

        return redirect()->route('forum-permission.index')->with('success', 'Forum permission updated successfully.');
    }

    public function destroy(ForumPermission $forumPermission)
    {
        $forumPermission->delete();

        return redirect()->route('forum-permission.index')->with('success', 'Forum permission deleted successfully.');
    }
}