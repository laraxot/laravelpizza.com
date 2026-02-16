<?php

declare(strict_types=1);

return [
    'fields' => [
        'recipient' => [
            'label' => 'recipient',
        ],
        'subject' => [
            'label' => 'subject',
        ],
        'status' => [
            'label' => 'status',
        ],
        'sent_at' => [
            'label' => 'sent_at',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'view' => [
            'label' => 'view',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
    ],
    'label' => 'Log',
    'plural_label' => 'Log (Plurale)',
    'navigation' => [
        'name' => 'Log',
        'plural' => 'Log',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Log',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Log',
        ],
        'edit' => [
            'label' => 'Modifica Log',
        ],
        'delete' => [
            'label' => 'Elimina Log',
        ],
    ],
];
