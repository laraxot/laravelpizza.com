<?php

declare(strict_types=1);

return [
    'sections' => [
        'header' => [
            'title' => 'Ordine confermato',
        ],
        'details' => [
            'title' => 'Dettagli dell\'ordine',
        ],
        'items' => [
            'title' => 'Articoli',
        ],
        'shipping_address' => [
            'title' => 'Indirizzo di spedizione',
        ],
    ],
    'messages' => [
        'confirmation' => [
            'message' => 'Grazie per il tuo acquisto! Abbiamo ricevuto il tuo ordine n. :order_id.',
        ],
        'questions' => [
            'message' => 'Hai domande sul tuo ordine?',
        ],
    ],
    'fields' => [
        'order_number' => [
            'label' => 'Numero ordine',
        ],
        'date' => [
            'label' => 'Data',
        ],
        'total' => [
            'label' => 'Totale',
        ],
        'quantity' => [
            'label' => 'Quantità',
        ],
    ],
    'actions' => [
        'track_order' => [
            'label' => 'Traccia il tuo ordine',
        ],
        'contact_support' => [
            'label' => 'Contatta l\'assistenza',
        ],
    ],
];
