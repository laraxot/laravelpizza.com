<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\json_decode;

class SeedEventsFromJsonAction
{
    use QueueableAction;

    /**
     * Seed events from a JSON file.
     *
     * @param  string|null  $filePath  Absolute path or relative to Module base.
     */
    public function execute(?string $filePath = null): void
    {
        if ($filePath === null) {
            $filePath = base_path('Modules/Meetup/database/json/events.json');
        }

        if (! File::exists($filePath)) {
            Log::error("Event seeding failed: File not found at {$filePath}");

            return;
        }

        $json = File::get($filePath);
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($data)) {
            Log::error("Event seeding failed: Invalid JSON format in {$filePath}");

            return;
        }

        foreach ($data as $eventData) {
            if (is_array($eventData)) {
                /** @var array<string, mixed> $eventData */
                $eventData = array_merge([], $eventData);
                $this->createEvent($eventData);
            }
        }
    }

    /**
     * Create or update an event from JSON data.
     *
     * @param  array<string, mixed>  $data
     */
    private function createEvent(array $data): void
    {
        Assert::keyExists($data, 'title');
        Assert::keyExists($data, 'date');
        Assert::keyExists($data, 'time');

        // Parse date and time to Carbon
        // Format expected: "December 15, 2025" and "6:00 PM - 9:00 PM"
        $dateStr = is_string($data['date']) ? $data['date'] : '';
        $timeRange = explode(' - ', is_string($data['time']) ? $data['time'] : '');
        $startTimeStr = $timeRange[0] ?? '00:00';
        $endTimeStr = $timeRange[1] ?? $startTimeStr;

        $title = is_string($data['title']) ? $data['title'] : 'Untitled';

        try {
            $startDate = Carbon::parse($dateStr.' '.$startTimeStr);
            $endDate = Carbon::parse($dateStr.' '.$endTimeStr);
        } catch (\Exception $e) {
            Log::warning("Skipping event '{$title}': Invalid date/time format. ".$e->getMessage());

            return;
        }

        // Map status to Enum
        $status = match ($data['status'] ?? 'upcoming') {
            'past' => EventStatus::SCHEDULED, // Could be specialized further if needed
            default => EventStatus::SCHEDULED,
        };

        // If the date is in the past, we could set status logic here,
        // but let's stick to the Schema.org default suggested by the model.

        Event::updateOrCreate(
            ['title' => $data['title'], 'start_date' => $startDate],
            [
                'description' => $data['description'] ?? null,
                'end_date' => $endDate,
                'location' => $data['location'] ?? 'Online',
                'status' => $data['status'] ?? 'upcoming',
                'event_status' => $status,
                'event_attendance_mode' => EventAttendanceMode::OFFLINE, // Default for these pizza meetups
                'attendees_count' => $data['attendees_current'] ?? 0,
                'max_attendees' => $data['attendees_max'] ?? 30,
                'url' => $data['url'] ?? null,
                'in_language' => app()->getLocale(),
            ]
        );
    }
}
