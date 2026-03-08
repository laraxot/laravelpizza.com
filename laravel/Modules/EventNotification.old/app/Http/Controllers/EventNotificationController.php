<?php

namespace Modules\EventNotification\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EventNotification\App\Models\EventNotification;

class EventNotificationController extends Controller
{
    public function index()
    {
        $eventNotifications = EventNotification::with(['event', 'user'])->paginate(15);
        return view('eventnotification::index', compact('eventNotifications'));
    }

    public function create()
    {
        $events = \Modules\Meetup\App\Models\Event::all();
        $users = \Modules\User\App\Models\User::all();
        return view('eventnotification::create', compact('events', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        EventNotification::create($request->all());

        return redirect()->route('event-notification.index')->with('success', 'Event notification created successfully.');
    }

    public function show(EventNotification $eventNotification)
    {
        $eventNotification->load(['event', 'user']);
        return view('eventnotification::show', compact('eventNotification'));
    }

    public function edit(EventNotification $eventNotification)
    {
        $eventNotification->load(['event', 'user']);
        $events = \Modules\Meetup\App\Models\Event::all();
        $users = \Modules\User\App\Models\User::all();
        return view('eventnotification::edit', compact('eventNotification', 'events', 'users'));
    }

    public function update(Request $request, EventNotification $eventNotification)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $eventNotification->update($request->all());

        return redirect()->route('event-notification.index')->with('success', 'Event notification updated successfully.');
    }

    public function destroy(EventNotification $eventNotification)
    {
        $eventNotification->delete();

        return redirect()->route('event-notification.index')->with('success', 'Event notification deleted successfully.');
    }
}