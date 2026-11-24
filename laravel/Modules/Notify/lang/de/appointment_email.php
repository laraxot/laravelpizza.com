<?php

declare(strict_types=1);

return [
    'sections' => [
        'cancelled' => [
            'title' => 'Terminabsage',
        ],
        'confirmed' => [
            'title' => 'Terminbestätigung',
            'description' => 'Wir freuen uns, Ihren Termin in unserer Einrichtung zu bestätigen.',
        ],
        'generic' => [
            'title' => 'Terminbenachrichtigung',
        ],
        'reminder' => [
            'title' => 'Terminerinnerung',
            'description' => 'Wir erinnern Sie daran, dass Ihr Termin in unserer Einrichtung für :when vorgesehen ist.',
        ],
        'rescheduled' => [
            'title' => 'Terminänderung',
        ],
    ],
    'cancelled' => [
        'status' => [
            'label' => 'abgesagt',
        ],
        'details' => [
            'title' => 'Details des abgesagten Termins',
        ],
        'rebook' => [
            'description' => 'Wenn Sie einen neuen Termin vereinbaren möchten, können Sie dies über unser Online-Buchungssystem tun oder sich direkt an unser Sekretariat wenden.',
        ],
        'new_button' => [
            'label' => 'Neuen Termin buchen',
        ],
    ],
    'common' => [
        'greeting' => [
            'label' => 'Sehr geehrte/r :name,',
        ],
        'status' => [
            'description' => 'Wir möchten Sie darüber informieren, dass Ihr Termin :status wurde.',
        ],
        'regards' => [
            'label' => 'Mit freundlichen Grüßen',
        ],
        'team' => [
            'label' => 'Das Projektteam',
        ],
        'auto_generated' => [
            'description' => 'Diese E-Mail wurde automatisch versendet. Bitte antworten Sie nicht auf diese Nachricht.',
        ],
        'rights_reserved' => [
            'label' => 'Alle Rechte vorbehalten',
        ],
        'details' => [
            'title' => 'Termindetails',
        ],
        'view_button' => [
            'label' => 'Termin anzeigen',
        ],
    ],
    'fields' => [
        'date' => [
            'label' => 'Datum',
        ],
        'time' => [
            'label' => 'Uhrzeit',
        ],
        'type' => [
            'label' => 'Art',
        ],
        'doctor' => [
            'label' => 'Arzt',
        ],
        'cancellation_reason' => [
            'label' => 'Grund der Absage',
        ],
        'location' => [
            'label' => 'Standort',
        ],
        'notes' => [
            'label' => 'Hinweise',
        ],
        'rescheduling_reason' => [
            'label' => 'Grund der Verschiebung',
        ],
    ],
    'confirmed' => [
        'arrive_early' => [
            'description' => 'Bitte erscheinen Sie 15 Minuten vor dem vereinbarten Termin, um eventuelle Formalitäten zu erledigen.',
        ],
        'cancel_notice' => [
            'description' => 'Sollten Sie den Termin nicht wahrnehmen können, kontaktieren Sie uns bitte mindestens 24 Stunden im Voraus, um ihn zu verschieben.',
        ],
        'questions' => [
            'description' => 'Bei Fragen oder Unklarheiten zögern Sie bitte nicht, uns zu kontaktieren.',
        ],
    ],
    'generic' => [
        'default' => [
            'message' => 'Wir möchten Sie über Ihren Termin in unserer Einrichtung informieren.',
        ],
        'contact_notice' => [
            'description' => 'Für weitere Informationen oder Anliegen kontaktieren Sie uns bitte jederzeit.',
        ],
    ],
    'reminder' => [
        'tomorrow' => [
            'label' => 'morgen',
        ],
        'countdown' => [
            'description' => 'Nur noch 1 Tag bis zu Ihrem Termin!',
        ],
        'arrive_early' => [
            'description' => 'Bitte erscheinen Sie 15 Minuten vor dem vereinbarten Termin und bringen Sie Folgendes mit:',
        ],
        'bring' => [
            'id' => 'Einen gültigen Ausweis',
            'health_card' => 'Krankenversicherungskarte',
            'reports' => 'Eventuelle frühere Befunde oder Untersuchungsergebnisse',
            'medications' => 'Eine Liste der Medikamente, die Sie einnehmen',
        ],
        'cancel_notice' => [
            'description' => 'Sollten Sie den Termin nicht wahrnehmen können, kontaktieren Sie uns bitte so bald wie möglich, um ihn zu verschieben.',
        ],
        'manage_button' => [
            'label' => 'Termin verwalten',
        ],
    ],
    'rescheduled' => [
        'status' => [
            'label' => 'verschoben',
        ],
        'previous_details' => [
            'title' => 'Bisherige Details',
        ],
        'new_details' => [
            'title' => 'Neue Termindetails',
        ],
        'incompatible_notice' => [
            'description' => 'Falls der neue Termin nicht zu Ihrem Zeitplan passt, kontaktieren Sie uns bitte so bald wie möglich, damit wir eine Alternative finden können.',
        ],
    ],
];
