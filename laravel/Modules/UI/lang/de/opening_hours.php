<?php

declare(strict_types=1);

return [
    'instructions' => [
        'title' => 'Öffnungszeiten Konfiguration',
        'description' => 'Stellen Sie die Öffnungszeiten für jeden Wochentag ein. Leer lassen für geschlossene Tage.',
    ],
    'headers' => [
        'day' => 'Tag',
        'morning' => 'Vormittag',
        'afternoon' => 'Nachmittag',
    ],
    'legend' => [
        'open' => 'Geöffnet',
        'closed' => 'Geschlossen',
        'format' => 'Format: HH:MM',
    ],
    'days' => [
        'monday' => 'Montag',
        'tuesday' => 'Dienstag',
        'wednesday' => 'Mittwoch',
        'thursday' => 'Donnerstag',
        'friday' => 'Freitag',
        'saturday' => 'Samstag',
        'sunday' => 'Sonntag',
    ],
    'periods' => [
        'morning' => 'Vormittag',
        'afternoon' => 'Nachmittag',
        'evening' => 'Abend',
    ],
    'labels' => [
        'morning' => 'Vormittag',
        'afternoon' => 'Nachmittag',
        'from' => 'Von',
        'to' => 'Bis',
        'closed' => 'Geschlossen',
    ],
    'descriptions' => [
        'day_schedule' => 'Konfigurieren Sie die Öffnungszeiten für diesen Tag',
    ],
    'placeholders' => [
        'morning_hours' => 'Vormittagszeiten',
        'afternoon_hours' => 'Nachmittagszeiten',
    ],
    'notes' => [
        'format_hint' => 'Verwenden Sie das 24-Stunden-Format (z.B. 14:30 für 14:30 Uhr)',
        'empty_hint' => 'Leer lassen bedeutet "geschlossen"',
    ],
    'validation' => [
        'invalid_format' => 'Ungültiges Zeitformat. Verwenden Sie HH:MM-HH:MM',
        'invalid_time_range' => 'Öffnungszeit muss vor Schließungszeit liegen',
        'overlapping_hours' => 'Zeiten können am selben Tag nicht überlappen',
        'from_before_to' => 'Die "Von"-Zeit muss vor der "Bis"-Zeit liegen',
        'to_after_from' => 'Die "Bis"-Zeit muss nach der "Von"-Zeit liegen',
        'time_sequence' => 'Startzeit muss vor Endzeit liegen',
        'morning_before_afternoon' => 'Für :day muss die Vormittags-Schließzeit vor der Nachmittags-Öffnungszeit liegen.',
        'missing_closing_time' => 'Wenn Sie :session Öffnungszeit für :day angeben, müssen Sie auch die Schließzeit angeben.',
        'missing_opening_time' => 'Wenn Sie :session Schließzeit für :day angeben, müssen Sie auch die Öffnungszeit angeben.',
        'opening_before_closing' => 'Die :session Öffnungszeit für :day muss vor der Schließzeit liegen.',
        'morning' => 'Vormittag',
        'afternoon' => 'Nachmittag',
        'opening_hours' => [
            'morning_before_afternoon' => 'Für :day muss die Vormittags-Schließzeit vor der Nachmittags-Öffnungszeit liegen.',
            'missing_closing_time' => 'Wenn Sie :session Öffnungszeit für :day angeben, müssen Sie auch die Schließzeit angeben.',
            'missing_opening_time' => 'Wenn Sie :session Schließzeit für :day angeben, müssen Sie auch die Öffnungszeit angeben.',
            'opening_before_closing' => 'Die :session Öffnungszeit für :day muss vor der Schließzeit liegen.',
            'morning' => 'Vormittag',
            'afternoon' => 'Nachmittag',
        ],
    ],
];
