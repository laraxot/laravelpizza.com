<?php

namespace Modules\EventFeedbackType\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EventFeedbackType\App\Models\EventFeedbackType;

class EventFeedbackTypeController extends Controller
{
    public function index()
    {
        $eventFeedbackTypes = EventFeedbackType::paginate(15);
        return view('eventfeedbacktype::index', compact('eventFeedbackTypes'));
    }

    public function create()
    {
        return view('eventfeedbacktype::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        EventFeedbackType::create($request->all());

        return redirect()->route('event-feedback-type.index')->with('success', 'Event feedback type created successfully.');
    }

    public function show(EventFeedbackType $eventFeedbackType)
    {
        return view('eventfeedbacktype::show', compact('eventFeedbackType'));
    }

    public function edit(EventFeedbackType $eventFeedbackType)
    {
        return view('eventfeedbacktype::edit', compact('eventFeedbackType'));
    }

    public function update(Request $request, EventFeedbackType $eventFeedbackType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $eventFeedbackType->update($request->all());

        return redirect()->route('event-feedback-type.index')->with('success', 'Event feedback type updated successfully.');
    }

    public function destroy(EventFeedbackType $eventFeedbackType)
    {
        $eventFeedbackType->delete();

        return redirect()->route('event-feedback-type.index')->with('success', 'Event feedback type deleted successfully.');
    }
}