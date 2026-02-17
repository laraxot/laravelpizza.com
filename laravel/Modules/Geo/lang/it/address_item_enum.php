<?php

declare(strict_types=1);

return [
    'phone' => [
        'label' => 'Telefono',
        'description' => 'Numero di telefono',
        'icon' => 'heroicon-o-phone',
        'color' => 'primary',
    ],
    'name' => [
        'label' => 'Nome',
        'description' => 'Nome del luogo o dell\'indirizzo',
        'icon' => 'heroicon-o-tag',
        'color' => 'secondary',
    ],
    'description' => [
        'label' => 'Descrizione',
        'description' => 'Descrizione dettagliata del luogo',
        'icon' => 'heroicon-o-document-text',
        'color' => 'gray',
    ],
    'route' => [
        'label' => 'Via',
        'description' => 'Nome della via o strada',
        'icon' => 'heroicon-o-map',
        'color' => 'success',
    ],
    'street_number' => [
        'label' => 'Numero Civico',
        'description' => 'Numero civico dell\'indirizzo',
        'icon' => 'heroicon-o-home',
        'color' => 'info',
    ],
    'locality' => [
        'label' => 'Località',
        'description' => 'Località o frazione',
        'icon' => 'heroicon-o-building-office-2',
        'color' => 'warning',
    ],
    'administrative_area_level_3' => [
        'label' => 'Comune',
        'description' => 'Comune di appartenza',
        'icon' => 'heroicon-o-building-office',
        'color' => 'primary',
    ],
    'administrative_area_level_2' => [
        'label' => 'Provincia',
        'description' => 'Provincia di appartenza',
        'icon' => 'heroicon-o-map-pin',
        'color' => 'danger',
    ],
    'administrative_area_level_1' => [
        'label' => 'Regione',
        'description' => 'Regione di appartenza',
        'icon' => 'heroicon-o-globe-alt',
        'color' => 'purple',
    ],
    'country' => [
        'label' => 'Paese',
        'description' => 'Stato o nazione',
        'icon' => 'heroicon-o-flag',
        'color' => 'success',
    ],
    'postal_code' => [
        'label' => 'CAP',
        'description' => 'Codice di avviamento postale',
        'icon' => 'heroicon-o-inbox',
        'color' => 'warning',
    ],
    'formatted_address' => [
        'label' => 'Indirizzo Formattato',
        'description' => 'Indirizzo completo formattato',
        'icon' => 'heroicon-o-document-text',
        'color' => 'gray',
    ],
    'place_id' => [
        'label' => 'ID Luogo',
        'description' => 'Identificativo univoco del luogo',
        'icon' => 'heroicon-o-finger-print',
        'color' => 'info',
    ],
    'latitude' => [
        'label' => 'Latitudine',
        'description' => 'Coordinate geografiche latitudine',
        'icon' => 'heroicon-o-map-pin',
        'color' => 'primary',
    ],
    'longitude' => [
        'label' => 'Longitudine',
        'description' => 'Coordinate geografiche longitudine',
        'icon' => 'heroicon-o-map-pin',
        'color' => 'primary',
    ],
    'fax' => [
        'label' => 'Fax',
        'description' => 'Numero fax',
        'icon' => 'heroicon-o-printer',
        'color' => 'gray',
    ],
    'mobile' => [
        'label' => 'Cellulare',
        'description' => 'Numero di telefono cellulare associato all\'indirizzo',
        'icon' => 'heroicon-o-device-phone-mobile',
        'color' => 'primary',
    ],
    'pec' => [
        'label' => 'PEC',
        'description' => 'Indirizzo di posta elettronica certificata (PEC] associato all\'indirizzo',
        'icon' => 'heroicon-o-shield-check',
        'color' => 'purple',
    ],
    'whatsapp' => [
        'label' => 'WhatsApp',
        'description' => 'Contatto WhatsApp associato all\'indirizzo',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'color' => 'success',
    ],
    'email' => [
        'label' => 'Email',
        'description' => 'Indirizzo email associato all\'indirizzo',
        'icon' => 'heroicon-o-envelope',
        'color' => 'info',
    ],
    'notes' => [
        'label' => 'Note',
        'description' => 'Note aggiuntive sull\'indirizzo',
        'icon' => 'heroicon-o-document-text',
        'color' => 'gray',
    ],
    'label' => 'Address Item Enum',
    'plural_label' => 'Address Item Enum (Plurale)',
    'navigation' => [
        'name' => 'Address Item Enum',
        'plural' => 'Address Item Enum',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Address Item Enum',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Address Item Enum',
        ],
        'edit' => [
            'label' => 'Modifica Address Item Enum',
        ],
        'delete' => [
            'label' => 'Elimina Address Item Enum',
        ],
    ],
];
