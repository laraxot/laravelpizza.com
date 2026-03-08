<?php

namespace Modules\ForumSubscriber\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ForumSubscriber\App\Models\ForumSubscriber;

class ForumSubscriberController extends Controller
{
    public function index()
    {
        $forumSubscribers = ForumSubscriber::with(['user', 'forum'])->paginate(15);
        return view('forumsubscriber::index', compact('forumSubscribers'));
    }

    public function create()
    {
        $users = \Modules\User\App\Models\User::all();
        $forums = \Modules\Cms\App\Models\Forum::all();
        return view('forumsubscriber::create', compact('users', 'forums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'forum_id' => 'required|exists:forums,id',
            'subscription_type' => 'required|string',
            'created_at' => 'nullable|date',
        ]);

        ForumSubscriber::create($request->all());

        return redirect()->route('forum-subscriber.index')->with('success', 'Forum subscriber created successfully.');
    }

    public function show(ForumSubscriber $forumSubscriber)
    {
        $forumSubscriber->load(['user', 'forum']);
        return view('forumsubscriber::show', compact('forumSubscriber'));
    }

    public function edit(ForumSubscriber $forumSubscriber)
    {
        $forumSubscriber->load(['user', 'forum']);
        $users = \Modules\User\App\Models\User::all();
        $forums = \Modules\Cms\App\Models\Forum::all();
        return view('forumsubscriber::edit', compact('forumSubscriber', 'users', 'forums'));
    }

    public function update(Request $request, ForumSubscriber $forumSubscriber)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'forum_id' => 'required|exists:forums,id',
            'subscription_type' => 'required|string',
            'created_at' => 'nullable|date',
        ]);

        $forumSubscriber->update($request->all());

        return redirect()->route('forum-subscriber.index')->with('success', 'Forum subscriber updated successfully.');
    }

    public function destroy(ForumSubscriber $forumSubscriber)
    {
        $forumSubscriber->delete();

        return redirect()->route('forum-subscriber.index')->with('success', 'Forum subscriber deleted successfully.');
    }
}