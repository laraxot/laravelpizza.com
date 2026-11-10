<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Str;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function Safe\fclose;
use function Safe\fopen;
use function Safe\fputcsv;
use function Safe\fwrite;

/**
 * PRD FR-4: elenco iscritti di un evento in CSV (nome, email, stato, data di iscrizione).
 * Separatore `;` e BOM UTF-8: il file si apre correttamente in Excel con impostazioni italiane.
 */
class ExportEventRegistrationsAction
{
    use QueueableAction;

    public function execute(Event $event): StreamedResponse
    {
        $filename = 'iscritti-'.Str::slug($event->slug ?? $event->title).'.csv';

        return response()->streamDownload(function () use ($event): void {
            $out = fopen('php://output', 'wb');

            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, $this->header(), ';', '"', '');

            foreach ($this->rows($event) as $row) {
                fputcsv($out, $row, ';', '"', '');
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * @return list<string>
     */
    public function header(): array
    {
        return [
            (string) __('meetup::registration.fields.user.name.label'),
            (string) __('meetup::registration.fields.user.email.label'),
            (string) __('meetup::registration.fields.status.label'),
            (string) __('meetup::registration.fields.created_at.label'),
        ];
    }

    /**
     * @return list<list<string>>
     */
    public function rows(Event $event): array
    {
        $registrations = EventUser::query()
            ->where('event_id', $event->getKey())
            ->with('user')
            ->orderBy('created_at')
            ->get();

        $rows = [];
        foreach ($registrations as $registration) {
            $rows[] = [
                self::safeCell((string) ($registration->user->name ?? '')),
                self::safeCell((string) ($registration->user->email ?? '')),
                $registration->status,
                $registration->created_at?->format('Y-m-d H:i') ?? '',
            ];
        }

        return $rows;
    }

    /**
     * Nomi scelti dagli utenti finiscono in un foglio di calcolo: un valore che inizia con = + - @
     * verrebbe eseguito come formula (CSV injection). Si antepone un apostrofo.
     */
    private static function safeCell(string $value): string
    {
        return $value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true) ? "'".$value : $value;
    }
}
