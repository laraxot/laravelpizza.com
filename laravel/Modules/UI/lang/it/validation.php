<?php

declare(strict_types=1);

return [
    'opening_hours' => [
        'morning' => 'mattino',
        'afternoon' => 'pomeriggio',
        'morning_before_afternoon' => 'Per :day, l\'orario di chiusura del mattino deve essere precedente all\'apertura del pomeriggio.',
        'missing_closing_time' => 'Se specifichi l\'orario di apertura del :session per :day, devi specificare anche quello di chiusura.',
        'missing_opening_time' => 'Se specifichi l\'orario di chiusura del :session per :day, devi specificare anche quello di apertura.',
        'opening_before_closing' => 'L\'orario di apertura del :session per :day deve essere precedente a quello di chiusura.',
    ],
];
