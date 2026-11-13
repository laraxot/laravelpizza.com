<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Utente Team',
        'plural' => 'Utenti Team',
        'label' => 'Utenti Team',
        'group' => [
            'name' => 'Teams',
            'description' => 'Gestione degli utenti associati ai team',
        ],
        'sort' => 65,
        'icon' => 'heroicon-o-user-group',
    ],
    'label' => 'Team User',
    'plural_label' => 'Team User (Plurale)',
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
        'team' => [
            'name' => [
                'label' => 'team.name',
            ],
        ],
        'user' => [
            'name' => [
                'label' => 'user.name',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Team User',
            'icon' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Team User',
        ],
        'delete' => [
            'label' => 'Elimina Team User',
            'icon' => 'delete',
        ],
        'logout' => [
            'icon' => 'logout',
        ],
        'createAnother' => [
            'icon' => 'createAnother',
        ],
        'save' => [
            'icon' => 'save',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'icon' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
        ],
        'profile' => [
            'icon' => 'profile',
        ],
    ],
    'sections' => [
        'empty' => [
            'label' => '',
            'heading' => '',
        ],
    ],
];
