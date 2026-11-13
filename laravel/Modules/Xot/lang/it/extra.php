<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Extra',
        'plural' => 'estras',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'Extra',
        'icon' => 'heroicon-o-plus',
        'sort' => 38,
    ],
    'pages' => [
        'health_check_results' => [
            'buttons' => [
                'refresh' => 'Refresh',
            ],
            'heading' => 'Application Health',
            'navigation' => [
                'group' => 'Settings',
                'label' => 'Application Health',
            ],
            'notifications' => [
                'check_results' => 'Check results from',
            ],
        ],
    ],
    'label' => 'Extra',
    'plural_label' => 'Extra (Plurale)',
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
        'value' => [
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Extra',
            'icon' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Extra',
            'icon' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Extra',
            'icon' => 'delete',
        ],
        'createAnother' => [
            'icon' => 'createAnother',
        ],
        'save' => [
            'icon' => 'save',
        ],
    ],
];
