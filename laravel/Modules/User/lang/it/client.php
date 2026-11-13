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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user' => [
            'email' => [
                'label' => 'Proprietario',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'create' => [
            'label' => 'Crea',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'Gestisci Colonne',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'Reimposta Filtri',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'recordId' => [
            'label' => 'ID Record',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'client_id' => [
            'tooltip' => '',
        ],
        'secret' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'plural' => [
        'model' => [
            'label' => 'client.plural.model',
        ],
    ],
    'actions' => [
<<<<<<< .merge_file_AGEvEP
        'reorderRecords' => ['icon' => 'reorderRecords', 'label' => 'reorderRecords', 'tooltip' => 'reorderRecords'],
        'openColumnManager' => ['icon' => 'openColumnManager', 'label' => 'openColumnManager', 'tooltip' => 'openColumnManager'],
        'applyTableColumnManager' => ['icon' => 'applyTableColumnManager', 'label' => 'applyTableColumnManager', 'tooltip' => 'applyTableColumnManager'],
        'resetFilters' => ['icon' => 'resetFilters', 'label' => 'resetFilters', 'tooltip' => 'resetFilters'],
        'applyFilters' => ['icon' => 'applyFilters', 'label' => 'applyFilters', 'tooltip' => 'applyFilters'],
        'openFilters' => ['icon' => 'openFilters', 'label' => 'openFilters', 'tooltip' => 'openFilters'],
        'delete' => ['icon' => 'delete', 'label' => 'delete', 'tooltip' => 'delete'],
        'edit' => ['icon' => 'edit', 'label' => 'edit', 'tooltip' => 'edit'],
        'create' => ['icon' => 'create', 'label' => 'create', 'tooltip' => 'create'],
        'attach' => ['icon' => 'attach', 'label' => 'attach', 'tooltip' => 'attach'],
        'detach' => ['icon' => 'detach', 'label' => 'detach', 'tooltip' => 'detach'],
        'cancel' => ['tooltip' => 'cancel', 'icon' => 'cancel', 'label' => 'cancel'],
        'logout' => ['tooltip' => 'logout', 'icon' => 'logout', 'label' => 'logout'],
        'createAnother' => ['tooltip' => 'createAnother', 'label' => 'createAnother', 'icon' => 'createAnother'],
        'attachAnother' => ['tooltip' => 'attachAnother'],
        'profile' => ['tooltip' => 'profile', 'icon' => 'profile', 'label' => 'profile'],
        'view' => ['tooltip' => 'view', 'icon' => 'view'],
        'submit' => ['tooltip' => 'submit', 'icon' => 'submit', 'label' => 'submit'],
        'associateExistingClient' => ['tooltip' => 'associateExistingClient', 'icon' => 'associateExistingClient', 'label' => 'associateExistingClient'],
        'save' => ['label' => 'save', 'icon' => 'save', 'tooltip' => 'save'],
        'resetColumnManager' => ['label' => 'resetColumnManager', 'icon' => 'resetColumnManager', 'tooltip' => 'resetColumnManager'],
        'dissociateClient' => ['label' => 'dissociateClient', 'icon' => 'dissociateClient', 'tooltip' => 'dissociateClient'],
    ],
    'sections' => [
        'empty' => ['heading' => ''],
=======
        'reorderRecords' => [
            'icon' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
        ],
        'delete' => [
            'icon' => 'delete',
        ],
        'edit' => [
            'icon' => 'edit',
        ],
        'create' => [
            'icon' => 'create',
        ],
        'attach' => [
            'icon' => 'attach',
        ],
        'detach' => [
            'icon' => 'detach',
        ],
        'cancel' => [
            'icon' => 'cancel',
        ],
        'logout' => [
            'icon' => 'logout',
        ],
        'createAnother' => [
            'icon' => 'createAnother',
        ],
        'profile' => [
            'icon' => 'profile',
        ],
        'view' => [
            'icon' => 'view',
        ],
        'submit' => [
            'icon' => 'submit',
        ],
        'associateExistingClient' => [
            'icon' => 'associateExistingClient',
        ],
        'save' => [
            'icon' => 'save',
        ],
        'resetColumnManager' => [
            'icon' => 'resetColumnManager',
        ],
        'dissociateClient' => [
            'icon' => 'dissociateClient',
        ],
>>>>>>> .merge_file_QUaF2J
    ],
    'label' => 'Client',
    'plural_label' => 'Client (Plurale)',
];
