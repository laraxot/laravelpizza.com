<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_split;

class ImportEventsFromJsonAction
{
    use QueueableAction;

    /**
     * Import events from JSON files.
     *
     * Supports two formats:
     * 1. Single file: database/json/events.json with {"events": [...]} structure
     * 2. Individual files: database/json/events/*.json (one file per event)
     *
     * Events are Schema.org/Event aligned.
     *
     * @see https://schema.org/Event
     */
    public function execute(?string $path = null, string $locale = 'it'): int
    {
        $modulePath = module_path('Meetup', 'database/json');
        $singleFile = $path ?? $modulePath.'/events.json';
        $directory = $modulePath.'/events';

        // Try single file first, then directory
        if (File::exists($singleFile)) {
            return $this->importFromSingleFile($singleFile, $locale);
        }

        if (File::exists($directory)) {
            return $this->importFromDirectory($directory, $locale);
        }

        Log::warning('ImportEventsFromJsonAction: no events file found', [
            'single_file' => $singleFile,
            'directory' => $directory,
        ]);

        return 0;
    }

    /**
     * Import from single events.json file.
     */
    protected function importFromSingleFile(string $path, string $locale): int
    {
        /** @var array<string, mixed> $payload */
        $payload = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);

        // Handle both {"events": [...]} and [...] formats
        if (isset($payload['events']) && is_array($payload['events'])) {
            $events = $payload['events'];
        } elseif (is_array($payload) && ! empty($payload)) {
            // Plain array format: [{...}, {...}]
            $events = $payload;
        } else {
            $events = [];
        }

        /** @var array<array<string, mixed>> $events */
        return $this->processEvents($events, $locale);
    }

    /**
     * Import from individual JSON files in events directory.
     */
    protected function importFromDirectory(string $directory, string $locale): int
    {
        $files = File::files($directory);
        $count = 0;

        foreach ($files as $file) {
            if ($file->getExtension() !== 'json') {
                continue;
            }

            try {
                /** @var array<string, mixed> $data */
                $data = json_decode(File::get($file->getPathname()), true, 512, JSON_THROW_ON_ERROR);
                $this->processSingleEvent($data, $locale);
                $count++;
            } catch (\Exception $e) {
                Log::warning('ImportEventsFromJsonAction: failed to import file', [
                    'file' => $file->getFilename(),
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return $count;
    }

    /**
     * Process multiple events.
     *
     * @param  array<array<string, mixed>>  $events
     */
    protected function processEvents(array $events, string $locale): int
    {
        $count = 0;
        foreach ($events as $item) {
            if (is_array($item)) {
                /** @var array<string, mixed> $item */
                $this->processSingleEvent($item, $locale);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Process a single event from array data.
     */
    protected function processSingleEvent(array $item, string $locale): Event
    {
        $start = $this->parseStart($item);
        $end = $this->parseEnd($item, $start);

        $status = strtolower((string) Arr::get($item, 'status', 'upcoming'));
        $eventStatus = match ($status) {
            'completed' => EventStatus::COMPLETED,
            'cancelled' => EventStatus::CANCELLED,
            'postponed' => EventStatus::POSTPONED,
            'rescheduled' => EventStatus::RESCHEDULED,
            default => EventStatus::SCHEDULED,
        };

        // Handle Schema.org format (start_date as ISO 8601)
        $startDateVal = $item['start_date'] ?? null;
        if (! empty($startDateVal) && is_string($startDateVal)) {
            $start = $this->parseIsoDate($startDateVal);
        }
        $endDateVal = $item['end_date'] ?? null;
        if (! empty($endDateVal) && is_string($endDateVal)) {
            $end = $this->parseIsoDate($endDateVal);
        }

        return Event::updateOrCreate(
            [
                'title' => Arr::get($item, 'title'),
                'start_date' => $start,
                'location' => Arr::get($item, 'location'),
            ],
            [
                'description' => Arr::get($item, 'description'),
                'in_language' => Arr::get($item, 'in_language', $locale),
                'end_date' => $end,
                'duration' => $this->duration($start, $end),
                'status' => $status,
                'event_status' => $eventStatus,
                'event_attendance_mode' => $this->parseAttendanceMode(is_string($item['event_attendance_mode'] ?? null) ? $item['event_attendance_mode'] : null),
                'attendees_count' => (int) Arr::get($item, 'attendees_count', Arr::get($item, 'attendees_current', 0)),
                'max_attendees' => (int) Arr::get($item, 'max_attendees', Arr::get($item, 'attendees_max', 0)) ?: 30,
                'url' => Arr::get($item, 'url'),
                'cover_image' => Arr::get($item, 'image'),
                'slug' => $this->generateSlug((string) Arr::get($item, 'title', 'event')),
                'offers' => $this->parseOffers($this->normalizeOffers($item['offers'] ?? null)),
                'meta_data' => [
                    'organizer' => Arr::get($item, 'organizer'),
                    'schema_original' => $item,
                ],
            ]
        );
    }

    /**
     * Parse start date from item array.
     */
    private function parseStart(array $item): Carbon
    {
        // ISO 8601 format (Schema.org)
        $startDateVal = $item['start_date'] ?? null;
        if (! empty($startDateVal) && is_string($startDateVal)) {
            return $this->parseIsoDate($startDateVal);
        }

        // Legacy format: separate date and time
        $date = (string) Arr::get($item, 'date', date('Y-m-d'));
        $timeRange = (string) Arr::get($item, 'time', '00:00');
        $splitParts = preg_split('/\s*-\s*/', $timeRange);
        [$startTime] = array_pad($splitParts, 1, '00:00');
        $startTime = is_string($startTime) ? $startTime : '00:00';

        return Carbon::parse(trim($date.' '.$startTime));
    }

    /**
     * Parse end date from item array.
     */
    private function parseEnd(array $item, Carbon $start): Carbon
    {
        // ISO 8601 format (Schema.org)
        $endDateVal = $item['end_date'] ?? null;
        if (! empty($endDateVal) && is_string($endDateVal)) {
            return $this->parseIsoDate($endDateVal);
        }

        // Legacy format: separate date and time
        $date = (string) Arr::get($item, 'date', date('Y-m-d'));
        $timeRange = (string) Arr::get($item, 'time', '');
        $parts = preg_split('/\s*-\s*/', $timeRange);
        $endTime = $parts[1] ?? null;
        $endTime = is_string($endTime) ? $endTime : null;

        return $endTime ? Carbon::parse(trim($date.' '.$endTime)) : $start;
    }

    /**
     * Parse ISO 8601 date string.
     */
    private function parseIsoDate(string $date): Carbon
    {
        try {
            return Carbon::parse($date);
        } catch (\Exception $e) {
            return Carbon::now();
        }
    }

    /**
     * Calculate duration in ISO 8601 format.
     */
    private function duration(Carbon $start, Carbon $end): ?string
    {
        if ($end->lessThanOrEqualTo($start)) {
            return null;
        }

        $minutes = $start->diffInMinutes($end);

        return sprintf('PT%dM', $minutes);
    }

    /**
     * Parse attendance mode to enum.
     */
    private function parseAttendanceMode(?string $mode): EventAttendanceMode
    {
        return match (strtolower($mode ?? '')) {
            'online' => EventAttendanceMode::ONLINE,
            'mixed' => EventAttendanceMode::MIXED,
            default => EventAttendanceMode::OFFLINE,
        };
    }

    /**
     * Normalize offers from mixed to array.
     *
     *
     * @return array<string, mixed>|null
     */
    private function normalizeOffers(mixed $offers): ?array
    {
        if (! is_array($offers)) {
            return null;
        }

        /** @var array<string, mixed> $offers */
        return $offers;
    }

    /**
     * Parse offers array for Schema.org Event.
     *
     * @param  array<string, mixed>|null  $offers
     * @return array<string, mixed>|null
     */
    private function parseOffers(?array $offers): ?array
    {
        if (empty($offers)) {
            return null;
        }

        return [
            'price' => $offers['price'] ?? '0',
            'priceCurrency' => $offers['priceCurrency'] ?? 'EUR',
            'availability' => $offers['availability'] ?? null,
        ];
    }

    /**
     * Generate a unique slug from title.
     */
    private function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Ensure unique slug
        while (Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
