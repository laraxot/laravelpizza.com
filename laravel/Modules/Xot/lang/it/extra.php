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
            'placeholder' => 'id',
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
        'model_type' => [
            'label' => 'model_type',
        ],
        'model_id' => [
            'label' => 'model_id',
        ],
        'extra_attributes' => [
            'label' => 'extra_attributes',
        ],
        'post_type' => [
            'label' => 'post_type',
            'placeholder' => 'post_type',
            'helper_text' => 'post_type',
            'description' => 'post_type',
        ],
        'post_id' => [
            'label' => 'post_id',
            'placeholder' => 'post_id',
            'helper_text' => 'post_id',
            'description' => 'post_id',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => '',
            'description' => 'value',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Extra',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Extra',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Extra',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
    ],
];
