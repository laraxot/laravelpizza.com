<?php

declare(strict_types=1);

// Pagine di errore (laravel/resources/views/errors/*, Themes/Meetup/resources/views/errors/page.blade.php)
return [
    '403' => [
        'title' => 'Zugriff verweigert',
        'message' => 'Diese Seite ist für dein Konto nicht verfügbar.',
    ],
    '404' => [
        'title' => 'Seite nicht gefunden',
        'message' => 'Die gesuchte Seite existiert nicht oder wurde verschoben.',
    ],
    '419' => [
        'title' => 'Sitzung abgelaufen',
        'message' => 'Die Seite war zu lange geöffnet. Lade sie neu und versuche es erneut.',
    ],
    '429' => [
        'title' => 'Zu viele Anfragen',
        'message' => 'Warte eine Minute und versuche es erneut.',
    ],
    '500' => [
        'title' => 'Etwas ist schiefgelaufen',
        'message' => 'Ein technisches Problem ist aufgetreten. Versuche es in ein paar Minuten erneut.',
    ],
    '503' => [
        'title' => 'Gleich zurück',
        'message' => 'Wir aktualisieren die Website. Versuche es in ein paar Minuten erneut.',
    ],
    'label' => 'Fehler',
    'actions' => [
        'home' => 'Zur Startseite',
        'events' => 'Nächste Events ansehen',
        'reload' => 'Seite neu laden',
        'login' => 'Anmelden',
    ],
];
