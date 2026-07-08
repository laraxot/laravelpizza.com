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
        'label' => 'device',
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
            'label' => 'id',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'mobile_id' => [
            'label' => 'mobile_id',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'device' => [
            'label' => 'device',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'platform' => [
            'label' => 'platform',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'browser' => [
            'label' => 'browser',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'version' => [
            'label' => 'version',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_robot' => [
            'label' => 'is_robot',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'robot' => [
            'label' => 'robot',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_desktop' => [
            'label' => 'is_desktop',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_mobile' => [
            'label' => 'is_mobile',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_tablet' => [
            'label' => 'is_tablet',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_phone' => [
            'label' => 'is_phone',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'logout_at' => [
            'label' => 'logout_at',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'label' => 'login_at',
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
        'create' => [
            'label' => 'create',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
