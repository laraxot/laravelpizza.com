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
        'sort' => '32',
        'icon' => 'ui-geo-place',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'category' => [
            'label' => 'Categoria',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'location' => [
            'label' => 'Località',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'rating' => [
            'label' => 'Valutazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'opening_hours' => [
            'label' => 'Orari di Apertura',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'contact_info' => [
            'label' => 'Contatti',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'website' => [
            'label' => 'Sito Web',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'photos' => [
            'label' => 'Foto',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'amenities' => [
            'label' => 'Servizi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
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
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
