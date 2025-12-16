<?php

declare(strict_types=1);

return [
    'instructions' => [
        'title' => 'Configurazione Orari',
        'description' => 'Imposta gli orari di apertura per ogni giorno della settimana. Lascia vuoto per giorni di chiusura.',
    ],
    'headers' => [
        'day' => 'Giorno',
        'morning' => 'Mattino',
        'afternoon' => 'Pomeriggio',
    ],
    'legend' => [
        'open' => 'Aperto',
        'closed' => 'Chiuso',
        'format' => 'Formato: HH:MM',
    ],
    'days' => [
        'monday' => 'Lunedì',
        'tuesday' => 'Martedì',
        'wednesday' => 'Mercoledì',
        'thursday' => 'Giovedì',
        'friday' => 'Venerdì',
        'saturday' => 'Sabato',
        'sunday' => 'Domenica',
    ],
    'periods' => [
        'morning' => 'Mattino',
        'afternoon' => 'Pomeriggio',
        'evening' => 'Sera',
    ],
    'labels' => [
        'morning' => 'Mattino',
        'afternoon' => 'Pomeriggio',
        'from' => 'Dalle',
        'to' => 'Alle',
        'closed' => 'Chiuso',
    ],
    'descriptions' => [
        'day_schedule' => 'Configura gli orari di apertura per questo giorno',
    ],
    'placeholders' => [
        'morning_hours' => 'Orari del mattino',
        'afternoon_hours' => 'Orari del pomeriggio',
    ],
    'notes' => [
        'format_hint' => 'Utilizzare il formato 24 ore (es. 14:30 per le 2:30 del pomeriggio)',
        'empty_hint' => 'Lasciare vuoto significa "chiuso"',
    ],
    'validation' => [
        'invalid_format' => 'Formato orario non valido. Utilizzare HH:MM-HH:MM',
        'invalid_time_range' => 'L\'orario di apertura deve essere precedente all\'orario di chiusura',
        'overlapping_hours' => 'Gli orari non possono sovrapporsi nello stesso giorno',
        'from_before_to' => 'L\'orario "Dalle" deve essere precedente all\'orario "Alle"',
        'to_after_from' => 'L\'orario "Alle" deve essere successivo all\'orario "Dalle"',
        'time_sequence' => 'L\'orario di inizio deve essere precedente a quello di fine',
        'morning_before_afternoon' => 'Per :day, l\'orario di chiusura del mattino deve essere precedente all\'apertura del pomeriggio.',
        'missing_closing_time' => 'Se specifichi l\'orario di apertura del :session  :day, devi specificare anche quello di chiusura.',
        'missing_opening_time' => 'Se specifichi l\'orario di chiusura del :session  :day, devi specificare anche quello di apertura.',
        'opening_before_closing' => 'L\'orario di apertura del :session per :day deve essere precedente a quello di chiusura.',
        'morning' => 'mattino',
        'afternoon' => 'pomeriggio',
        'opening_hours' => [
            'morning_before_afternoon' => 'Per :day, l\'orario di chiusura del mattino deve essere precedente all\'apertura del pomeriggio.',
            'missing_closing_time' => 'Se specifichi l\'orario di apertura del :session  :day, devi specificare anche quello di chiusura.',
            'missing_opening_time' => 'Se specifichi l\'orario di chiusura del :session  :day, devi specificare anche quello di apertura.',
            'opening_before_closing' => 'L\'orario di apertura del :session  :day deve essere precedente a quello di chiusura.',
            'morning' => 'mattino',
            'afternoon' => 'pomeriggio',
        ],
    ],
];
