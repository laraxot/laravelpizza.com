<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Venue;
use Spatie\QueueableAction\QueueableAction;

/**
 * Un evento in forma di dati semplici, per chi non legge l'HTML: i tool del server MCP (e in futuro l'agente in chat).
 * Solo dati pubblici: niente email dell'organizzatore né elenco degli iscritti.
 */
class BuildEventSummaryAction
{
    use QueueableAction;

    /**
     * @return array{slug: string, title: string, starts_at: ?string, ends_at: ?string, city: ?string, venue: ?string, address: ?string, capacity: int, spots_left: int, is_full: bool, url: string, registered?: bool, description?: ?string}
     */
    public function execute(Event $event, ?string $userId = null, bool $withDescription = false, ?string $locale = null): array
    {
        $venue = $event->venue;
        $capacity = (int) $event->max_attendees;

        $summary = [
            'slug' => (string) $event->slug,
            'title' => (string) $event->title,
            'starts_at' => $event->start_date instanceof Carbon ? $event->start_date->toIso8601String() : null,
            'ends_at' => $event->end_date instanceof Carbon ? $event->end_date->toIso8601String() : null,
            'city' => is_string($event->location) && $event->location !== '' ? $event->location : null,
            'venue' => $venue instanceof Venue && is_string($venue->name) ? $venue->name : null,
            'address' => $venue instanceof Venue && is_string($venue->address) ? $venue->address : null,
            'capacity' => $capacity,
            'spots_left' => max(0, $capacity - (int) $event->attendees_count),
            'is_full' => $event->isFull(),
            'url' => $this->url($event, $locale),
        ];

        if ($userId !== null) {
            $summary['registered'] = $event->isUserRegistered($userId);
        }
        if ($withDescription) {
            $summary['description'] = is_string($event->description) ? $event->description : null;
        }

        return $summary;
    }

    private function url(Event $event, ?string $locale): string
    {
        $locale ??= LaravelLocalization::getDefaultLocale();
        $url = LaravelLocalization::getLocalizedURL($locale, '/events/'.$event->slug, [], true);

        return is_string($url) ? $url : url('/'.$locale.'/events/'.$event->slug);
    }
}
