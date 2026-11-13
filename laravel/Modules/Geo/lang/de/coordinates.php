<?php

declare(strict_types=1);

return [
    'fields' => [
        'latitude' => [
            'label' => 'Breitengrad',
            'placeholder' => 'Breitengrad eingeben',
        ],
        'longitude' => [
            'label' => 'Längengrad',
            'placeholder' => 'Längengrad eingeben',
        ],
    ],
    'address_form' => [
        'section' => [
            'heading' => 'Koordinaten',
            'description' => 'Breiten- und Längengrad. Adresse zuerst speichern, dann die Koordinaten für Entfernung und Karte aktualisieren.',
        ],
        'geocode' => [
            'label' => 'Aus Adresse aktualisieren',
            'success_title' => 'Koordinaten aus Adresse aktualisiert',
            'failed_title' => 'Geocodierung fehlgeschlagen',
        ],
        'map' => [
            'heading' => 'Kartenansicht des Standorts',
            'aria_label' => 'Kartenansicht des Standorts',
            'google_maps' => 'In Google Maps öffnen',
            'viamichelin' => 'In ViaMichelin öffnen',
            'missing' => 'Koordinaten sind nicht verfügbar. Adresse vervollständigen und „Aus Adresse aktualisieren“ im Abschnitt Koordinaten verwenden.',
        ],
    ],
];
