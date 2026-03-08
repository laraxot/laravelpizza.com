<?php

namespace Modules\EventAnalytics\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EventAnalytics\App\Models\EventAnalytics;

class EventAnalyticsController extends Controller
{
    public function index()
    {
        $eventAnalytics = EventAnalytics::with('event')->paginate(15);
        return view('eventanalytics::index', compact('eventAnalytics'));
    }

    public function create()
    {
        $events = \Modules\Meetup\App\Models\Event::all();
        return view('eventanalytics::create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'metric_name' => 'required|string|max:255',
            'metric_value' => 'required|numeric',
            'recorded_at' => 'nullable|date',
        ]);

        EventAnalytics::create($request->all());

        return redirect()->route('event-analytics.index')->with('success', 'Event analytics created successfully.');
    }

    public function show(EventAnalytics $eventAnalytics)
    {
        $eventAnalytics->load('event');
        return view('eventanalytics::show', compact('eventAnalytics'));
    }

    public function edit(EventAnalytics $eventAnalytics)
    {
        $eventAnalytics->load('event');
        $events = \Modules\Meetup\App\Models\Event::all();
        return view('eventanalytics::edit', compact('eventAnalytics', 'events'));
    }

    public function update(Request $request, EventAnalytics $eventAnalytics)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'metric_name' => 'required|string|max:255',
            'metric_value' => 'required|numeric',
            'recorded_at' => 'nullable|date',
        ]);

        $eventAnalytics->update($request->all());

        return redirect()->route('event-analytics.index')->with('success', 'Event analytics updated successfully.');
    }

    public function destroy(EventAnalytics $eventAnalytics)
    {
        $eventAnalytics->delete();

        return redirect()->route('event-analytics.index')->with('success', 'Event analytics deleted successfully.');
    }
}