<?php

namespace Modules\EventAttendee\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EventAttendee\App\Models\EventAttendee;

class EventAttendeeController extends Controller
{
    public function index()
    {
        $eventAttendees = EventAttendee::with(['event', 'user'])->paginate(15);
        return view('eventattendee::index', compact('eventAttendees'));
    }

    public function create()
    {
        $events = \Modules\Meetup\App\Models\Event::all();
        $users = \Modules\User\App\Models\User::all();
        return view('eventattendee::create', compact('events', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'registration_date' => 'required|date',
            'status' => 'required|string',
            'ticket_type' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        EventAttendee::create($request->all());

        return redirect()->route('event-attendee.index')->with('success', 'Event attendee created successfully.');
    }

    public function show(EventAttendee $eventAttendee)
    {
        $eventAttendee->load(['event', 'user']);
        return view('eventattendee::show', compact('eventAttendee'));
    }

    public function edit(EventAttendee $eventAttendee)
    {
        $eventAttendee->load(['event', 'user']);
        $events = \Modules\Meetup\App\Models\Event::all();
        $users = \Modules\User\App\Models\User::all();
        return view('eventattendee::edit', compact('eventAttendee', 'events', 'users'));
    }

    public function update(Request $request, EventAttendee $eventAttendee)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'registration_date' => 'required|date',
            'status' => 'required|string',
            'ticket_type' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $eventAttendee->update($request->all());

        return redirect()->route('event-attendee.index')->with('success', 'Event attendee updated successfully.');
    }

    public function destroy(EventAttendee $eventAttendee)
    {
        $eventAttendee->delete();

        return redirect()->route('event-attendee.index')->with('success', 'Event attendee deleted successfully.');
    }
}