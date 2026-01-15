<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Client',
        'plural' => 'Clients',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei client e delle loro autorizzazioni',
        ],
        'label' => 'Client',
        'sort' => 92,
        'icon' => 'heroicon-o-key',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'user' => [
            'email' => [
                'label' => 'Proprietario',
            ],
        ],
        'create' => [
            'label' => 'Crea',
        ],
        'edit' => [
            'label' => 'Modifica',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
        'toggleColumns' => [
            'label' => 'Gestisci Colonne',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
        ],
        'resetFilters' => [
            'label' => 'Reimposta Filtri',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
        ],
        'recordId' => [
            'label' => 'ID Record',
        ],
        'client_id' => [
            'description' => 'client_id',
            'helper_text' => 'client_id',
            'placeholder' => 'client_id',
            'label' => 'client_id',
        ],
        'secret' => [
            'label' => 'secret',
        ],
        'id' => [
            'label' => 'id',
        ],
    ],
    'plural' => [
        'model' => [
            'label' => 'client.plural.model',
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
            'label' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'delete' => [
            'icon' => 'delete',
            'label' => 'delete',
            'tooltip' => 'delete',
        ],
        'edit' => [
            'icon' => 'edit',
            'label' => 'edit',
            'tooltip' => 'edit',
        ],
        'create' => [
            'icon' => 'create',
            'label' => 'create',
            'tooltip' => 'create',
        ],
        'attach' => [
            'icon' => 'attach',
            'label' => 'attach',
            'tooltip' => 'attach',
        ],
        'detach' => [
            'icon' => 'detach',
            'label' => 'detach',
            'tooltip' => 'detach',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
        ],
        'attachAnother' => [
            'tooltip' => 'attachAnother',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'view' => [
            'tooltip' => 'view',
            'icon' => 'view',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
            'label' => 'submit',
        ],
        'associateExistingClient' => [
            'tooltip' => 'associateExistingClient',
            'icon' => 'associateExistingClient',
            'label' => 'associateExistingClient',
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
        ],
    ],
    'label' => '',
    'plural_label' => '',
];
