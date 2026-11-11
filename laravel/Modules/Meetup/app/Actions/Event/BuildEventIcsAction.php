<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;
use Spatie\QueueableAction\QueueableAction;

use function Safe\parse_url;

/**
 * Evento in formato iCalendar (RFC 5545): allegato alle email di conferma e promemoria e scaricabile dalla pagina
 * dell'evento ("Aggiungi al calendario"). Funziona con Google Calendar, Outlook, Apple Calendario.
 */
class BuildEventIcsAction
{
    use QueueableAction;

    public function execute(Event $event): string
    {
        $start = ($event->start_date ?? Carbon::now())->copy()->utc();
        $end = ($event->end_date ?? $start->copy()->addHours(2))->copy()->utc();
        $appUrl = config('app.url');
        $host = is_string($appUrl) ? parse_url($appUrl, PHP_URL_HOST) : null;
        $url = LaravelLocalization::localizeUrl('/events/'.($event->slug ?? ''));
        $location = $event->venue !== null
            ? trim($event->venue->name.', '.($event->venue->address ?? '').' '.($event->venue->city ?? ''), ' ,')
            : (string) $event->location;

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Laravel Pizza Meetups//IT',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:event-'.$event->id.'@'.(is_string($host) && $host !== '' ? $host : 'laravelpizza'),
            'DTSTAMP:'.Carbon::now()->utc()->format('Ymd\THis\Z'),
            'DTSTART:'.$start->format('Ymd\THis\Z'),
            'DTEND:'.$end->format('Ymd\THis\Z'),
            'SUMMARY:'.self::escape((string) $event->title),
            'DESCRIPTION:'.self::escape(Str::limit(strip_tags((string) $event->description), 500).($url !== '' ? "\n".$url : '')),
            'LOCATION:'.self::escape($location),
            'URL:'.$url,
            'STATUS:'.($event->status === 'cancelled' ? 'CANCELLED' : 'CONFIRMED'),
            'END:VEVENT',
            'END:VCALENDAR',
        ];

        return implode("\r\n", array_map(self::fold(...), $lines))."\r\n";
    }

    public function filename(Event $event): string
    {
        return Str::slug((string) ($event->slug ?? $event->title)).'.ics';
    }

    /**
     * Testo RFC 5545: backslash, punto e virgola, virgola e a capo vanno protetti.
     */
    private static function escape(string $text): string
    {
        return str_replace(['\\', ';', ',', "\r\n", "\n", "\r"], ['\\\\', '\;', '\,', '\n', '\n', ''], $text);
    }

    /**
     * Righe al massimo di 75 ottetti: le successive iniziano con uno spazio (line folding).
     */
    private static function fold(string $line): string
    {
        if (strlen($line) <= 75) {
            return $line;
        }

        $chunks = [];
        while (strlen($line) > 75) {
            $cut = 75;
            // Non spezzare un carattere UTF-8 a meta'.
            while ($cut > 0 && (ord($line[$cut]) & 0xC0) === 0x80) {
                $cut--;
            }
            $chunks[] = substr($line, 0, $cut);
            $line = ' '.substr($line, $cut);
        }
        $chunks[] = $line;

        return implode("\r\n", $chunks);
    }
}
