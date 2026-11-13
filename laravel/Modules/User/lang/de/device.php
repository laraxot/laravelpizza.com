<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Dispositivo',
        'plural' => 'Dispositivi',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei dispositivi degli utenti',
        ],
        'label' => 'Gerät',
        'sort' => '20',
        'icon' => 'user-device',
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'mobile_id' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'device' => [
            'label' => 'Gerät',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'platform' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'browser' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'version' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_robot' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'robot' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_desktop' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_mobile' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_tablet' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_phone' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'logout_at' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
