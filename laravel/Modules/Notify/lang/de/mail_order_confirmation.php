<?php

declare(strict_types=1);

return [
    'sections' => [
        'header' => [
            'title' => 'Bestellung bestätigt',
        ],
        'details' => [
            'title' => 'Bestelldetails',
        ],
        'items' => [
            'title' => 'Artikel',
        ],
        'shipping_address' => [
            'title' => 'Lieferadresse',
        ],
    ],
    'messages' => [
        'confirmation' => [
            'message' => 'Vielen Dank für Ihren Einkauf! Wir haben Ihre Bestellung Nr. :order_id erhalten.',
        ],
        'questions' => [
            'message' => 'Haben Sie Fragen zu Ihrer Bestellung?',
        ],
    ],
    'fields' => [
        'order_number' => [
            'label' => 'Bestellnummer',
        ],
        'date' => [
            'label' => 'Datum',
        ],
        'total' => [
            'label' => 'Gesamtsumme',
        ],
        'quantity' => [
            'label' => 'Menge',
        ],
    ],
    'actions' => [
        'track_order' => [
            'label' => 'Sendung verfolgen',
        ],
        'contact_support' => [
            'label' => 'Support kontaktieren',
        ],
    ],
];
