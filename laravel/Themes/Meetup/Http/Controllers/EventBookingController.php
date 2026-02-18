<?php

declare(strict_types=1);

namespace Themes\Meetup\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Meetup\Models\Event;

/**
 * Event Booking Controller
 * Handles API requests for event booking
 */
class EventBookingController
{
    /**
     * Book spots for an event
     */
    public function book(Request $request, string $slug): JsonResponse
    {
        /** @var array{name: string, email: string, spots: int} $validated */
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email',
            'spots' => 'required|integer|min:1|max:5',
        ]);

        $event = Event::where('slug', $slug)->first();

        if (! $event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found',
            ], 404);
        }

        $currentAttendees = (int) ($event->attendees_count ?? 0);
        $maxAttendees = (int) ($event->max_attendees ?? 100);
        $availableSpots = $maxAttendees - $currentAttendees;

        if ($validated['spots'] > $availableSpots) {
            return response()->json([
                'success' => false,
                'message' => "Only {$availableSpots} spots available",
            ], 422);
        }

        try {
            $event->attendees_count = $currentAttendees + $validated['spots'];
            $event->save();

            // Here you would typically also create a booking record
            // with attendee details in a separate table

            return response()->json([
                'success' => true,
                'message' => 'Booked successfully',
                'data' => [
                    'spots_booked' => $validated['spots'],
                    'total_attendees' => $event->attendees_count,
                    'available_spots' => $maxAttendees - $event->attendees_count,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Booking failed. Please try again.',
            ], 500);
        }
    }
}
