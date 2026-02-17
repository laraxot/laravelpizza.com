<?php

declare(strict_types=1);

return [
    'mail' => [
        'label' => 'Mail',
    ],
    'sms' => [
        'label' => 'SMS',
    ],
    'whatsapp' => [
        'label' => 'WhatsApp',
    ],
    'label' => 'Channel Enum',
    'plural_label' => 'Channel Enum (Plurale)',
    'navigation' => [
        'name' => 'Channel Enum',
        'plural' => 'Channel Enum',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Channel Enum',
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
            'label' => 'Crea Channel Enum',
        ],
        'edit' => [
            'label' => 'Modifica Channel Enum',
        ],
        'delete' => [
            'label' => 'Elimina Channel Enum',
        ],
    ],
];
