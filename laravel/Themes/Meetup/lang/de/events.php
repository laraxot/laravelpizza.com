<?php

declare(strict_types=1);

return [
    'status' => [
        'all' => [
            'label' => 'Alle Events',
            'description' => 'Filterlabel: alle Events',
        ],
        'upcoming' => [
            'label' => 'Bevorstehend',
            'description' => 'Label: kommende Events',
        ],
        'past' => [
            'label' => 'Vergangene Events',
            'description' => 'Label: vergangene Events',
        ],
    ],

    'fields' => [
        'about_this_event' => [
            'label' => 'Über dieses Event',
            'description' => 'Abschnittstitel für Eventbeschreibung',
        ],
        'event_details' => [
            'label' => 'Eventdetails',
            'description' => 'Abschnittstitel für Eventinformationen',
        ],
        'date' => [
            'label' => 'Datum',
            'description' => 'Label für Eventdatum',
        ],
        'time' => [
            'label' => 'Uhrzeit',
            'description' => 'Label für Eventzeit',
        ],
        'location' => [
            'label' => 'Ort',
            'description' => 'Label für Eventort',
        ],
        'language' => [
            'label' => 'Sprache',
            'description' => 'Label für Eventsprache',
        ],
        'attendees' => [
            'label' => 'Teilnehmende',
            'description' => 'Label für Teilnehmende',
        ],
        'people_joined' => [
            'label' => ':count Personen sind dabei',
            'description' => 'Nachricht: Anzahl Teilnehmende',
        ],
        'available_spots' => [
            'label' => ':count Plätze verfügbar',
            'description' => 'Nachricht: verfügbare Plätze',
        ],
        'spots_filled' => [
            'label' => 'Plätze belegt',
            'description' => 'Label für belegte Plätze',
        ],
    ],

    'actions' => [
        'back_to_events' => [
            'label' => 'Zurück zu den Events',
            'tooltip' => 'Zur Eventliste zurückkehren',
            'helper_text' => '',
            'description' => 'Link zurück zur Eventliste',
            'icon' => 'heroicon-o-arrow-left',
            'color' => 'secondary',
        ],
        'register_now' => [
            'label' => 'Jetzt anmelden',
            'tooltip' => 'Platz reservieren',
            'helper_text' => '',
            'description' => 'CTA für Anmeldung',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'primary',
        ],
        'join_event' => [
            'label' => 'An diesem Event teilnehmen',
            'tooltip' => 'Zur Teilnahme anmelden',
            'helper_text' => '',
            'description' => 'CTA zur Teilnahme',
            'icon' => 'heroicon-o-user-plus',
            'color' => 'primary',
        ],
        'book_your_spot' => [
            'label' => 'Jetzt Platz sichern!',
            'tooltip' => 'Platz reservieren',
            'helper_text' => '',
            'description' => 'CTA Dringlichkeit',
            'icon' => 'heroicon-o-ticket',
            'color' => 'primary',
        ],
        'share_event' => [
            'label' => 'Dieses Event teilen',
            'tooltip' => 'Mit Freunden teilen',
            'helper_text' => '',
            'description' => 'Label für Teilen-Button',
            'icon' => 'heroicon-o-share',
            'color' => 'secondary',
        ],
    ],

    'messages' => [
        'no_events_found' => [
            'label' => 'Keine Events gefunden',
            'description' => 'Nachricht, wenn keine Events verfügbar sind',
        ],
        'check_back_later' => [
            'label' => 'Später erneut versuchen',
            'description' => 'Hinweis später wiederzukommen',
        ],
        'event_fallback_title' => [
            'label' => 'Event',
            'description' => 'Fallback-Titel wenn Eventtitel fehlt',
        ],
        'spots_filling_fast' => [
            'label' => 'Die Plätze werden knapp!',
            'description' => 'Dringlichkeit bei begrenzten Plätzen',
        ],
        'event_location' => [
            'label' => 'Veranstaltungsort',
            'description' => 'Titel für Standortbereich',
        ],
        'map_loading' => [
            'label' => 'Karte wird geladen...',
            'description' => 'Nachricht während die Karte lädt',
        ],
        'click_to_view' => [
            'label' => 'Auf Google Maps ansehen',
            'description' => 'Hinweis: in Google Maps öffnen',
        ],
    ],
];
