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
        $payload = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        $events = Arr::get($payload, 'events');
        if (! is_array($events)) {
            $events = is_array($payload) ? $payload : [];
        }

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
     */
    protected function processEvents(array $events, string $locale): int
    {
        $count = 0;
        foreach ($events as $item) {
            $this->processSingleEvent($item, $locale);
            $count++;
        }

        return $count;
    }

    /**
     * Process a single event from array data.
     *
     * @param array<string, mixed> $item
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
        if (! empty($item['start_date'])) {
            $start = $this->parseIsoDate($item['start_date']);
        }
        if (! empty($item['end_date'])) {
            $end = $this->parseIsoDate($item['end_date']);
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
                'event_attendance_mode' => $this->parseAttendanceMode(Arr::get($item, 'event_attendance_mode')),
                'attendees_count' => (int) Arr::get($item, 'attendees_count', Arr::get($item, 'attendees_current', 0)),
                'max_attendees' => (int) Arr::get($item, 'max_attendees', Arr::get($item, 'attendees_max', 0)) ?: 30,
                'url' => Arr::get($item, 'url'),
                'cover_image' => Arr::get($item, 'image'),
                'offers' => $this->parseOffers(Arr::get($item, 'offers')),
                'meta_data' => [
                    'slug' => Str::slug(Arr::get($item, 'title', 'event')),
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
        if (! empty($item['start_date'])) {
            return $this->parseIsoDate($item['start_date']);
        }

        // Legacy format: separate date and time
        $date = (string) Arr::get($item, 'date', date('Y-m-d'));
        $timeRange = (string) Arr::get($item, 'time', '00:00');
        [$startTime] = array_pad(preg_split('/\s*-\s*/', $timeRange), 1, '00:00');

        return Carbon::parse(trim($date.' '.$startTime));
    }

    /**
     * Parse end date from item array.
     */
    private function parseEnd(array $item, Carbon $start): Carbon
    {
        // ISO 8601 format (Schema.org)
        if (! empty($item['end_date'])) {
            return $this->parseIsoDate($item['end_date']);
        }

        // Legacy format: separate date and time
        $date = (string) Arr::get($item, 'date', date('Y-m-d'));
        $timeRange = (string) Arr::get($item, 'time', '');
        $parts = preg_split('/\s*-\s*/', $timeRange);
        $endTime = $parts[1] ?? null;

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
     * Parse offers array for Schema.org Event.
     *
     * @param array<string, mixed>|null $offers
     *
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
}
