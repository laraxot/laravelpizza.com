<?php

namespace Modules\EventOrganizer\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\EventOrganizer\App\Models\EventOrganizer;

class EventOrganizerController extends Controller
{
    public function index()
    {
        $eventOrganizers = EventOrganizer::paginate(15);
        return view('eventorganizer::index', compact('eventOrganizers'));
    }

    public function create()
    {
        return view('eventorganizer::create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'event_id' => 'nullable|exists:events,id',
        ]);

        EventOrganizer::create($data);
        return redirect()->route('event-organizer.index')->with('success', 'Event Organizer created successfully.');
    }

    public function show(EventOrganizer $eventOrganizer)
    {
        return view('eventorganizer::show', compact('eventOrganizer'));
    }

    public function edit(EventOrganizer $eventOrganizer)
    {
        return view('eventorganizer::edit', compact('eventOrganizer'));
    }

    public function update(EventOrganizer $eventOrganizer)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'organization' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $eventOrganizer->update($data);
        return redirect()->route('event-organizer.index')->with('success', 'Event Organizer updated successfully.');
    }

    public function destroy(EventOrganizer $eventOrganizer)
    {
        $eventOrganizer->delete();
        return redirect()->route('event-organizer.index')->with('success', 'Event Organizer deleted successfully.');
    }
}