<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Luoghi',
        'plural' => 'Luoghi',
        'group' => [
            'name' => 'Geo',
            'description' => 'Gestione dei luoghi e punti di interesse',
        ],
        'label' => 'Luoghi',
        'sort' => 32,
        'icon' => 'ui-geo-place',
    ],
    'fields' => [
        'name' => 'Nome',
        'description' => 'Descrizione',
        'category' => 'Categoria',
        'location' => 'Località',
        'rating' => 'Valutazione',
        'opening_hours' => 'Orari di Apertura',
        'contact_info' => 'Contatti',
        'website' => 'Sito Web',
        'photos' => 'Foto',
        'amenities' => 'Servizi',
    ],
    'categories' => [
        'restaurant' => 'Ristorante',
        'hotel' => 'Hotel',
        'shopping' => 'Shopping',
        'entertainment' => 'Intrattenimento',
        'service' => 'Servizi',
        'culture' => 'Cultura',
    ],
    'actions' => [
        'add_review' => 'Aggiungi Recensione',
        'upload_photo' => 'Carica Foto',
        'share' => 'Condividi',
        'bookmark' => 'Salva',
    ],
];
