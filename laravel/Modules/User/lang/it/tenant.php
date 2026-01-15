<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Tenant',
        'plural' => 'Tenants',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei tenant e delle loro configurazioni',
        ],
        'label' => 'tenant',
        'sort' => 30,
        'icon' => 'ui-user-user-tenant',
    ],
    'table' => [
        'heading' => 'Tenant',
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'tooltip' => 'Nome del tenant',
            'description' => 'Nome di battesimo del tenant',
            'helper_text' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'tooltip' => 'Cognome del tenant',
            'description' => 'Cognome di famiglia del tenant',
            'helper_text' => '',
        ],
        'secondary_color' => [
            'label' => 'Colore Secondario',
            'placeholder' => 'Seleziona colore secondario',
            'tooltip' => 'Colore secondario del tema',
            'description' => 'Colore utilizzato come tono secondario nell\'interfaccia',
            'helper_text' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'inserisci-slug-univoco',
            'tooltip' => 'Identificatore URL-friendly',
            'description' => 'Identificatore univoco utilizzato negli URL',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Nome Tenant',
            'placeholder' => 'Inserisci nome del tenant',
            'tooltip' => 'Nome identificativo del tenant',
            'description' => 'Nome completo o ragione sociale del tenant',
            'helper_text' => '',
        ],
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID univoco',
            'tooltip' => 'Identificatore univoco',
            'description' => 'Chiave primaria del tenant nel database',
            'helper_text' => '',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio',
            'tooltip' => 'Messaggio informativo',
            'description' => 'Messaggio di comunicazione per il tenant',
            'helper_text' => '',
        ],
        'resetFilters' => [
            'label' => 'Azzera Filtri',
            'placeholder' => 'Clicca per azzerare',
            'tooltip' => 'Rimuove tutti i filtri applicati',
            'description' => 'Azione per rimuovere tutti i filtri attivi',
            'helper_text' => '',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'placeholder' => 'Clicca per applicare',
            'tooltip' => 'Applica i filtri selezionati',
            'description' => 'Azione per applicare i filtri configurati',
            'helper_text' => '',
        ],
        'recordId' => [
            'description' => 'recordId',
            'helper_text' => 'recordId',
            'placeholder' => 'recordId',
            'label' => 'recordId',
        ],
        'primary_color' => [
            'description' => 'primary_color',
            'helper_text' => 'primary_color',
            'placeholder' => 'primary_color',
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
        'change_password' => 'Cambio password',
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'cancel' => [
            'icon' => 'ui-cancel',
            'label' => 'cancel',
        ],
        'attachAnother' => [
            'icon' => 'attachAnother',
            'label' => 'attachAnother',
            'tooltip' => 'attachAnother',
        ],
        'submit' => [
            'icon' => 'submit',
            'label' => 'submit',
            'tooltip' => 'submit',
        ],
        'detach' => [
            'icon' => 'detach',
            'label' => 'detach',
            'tooltip' => 'detach',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'attach' => [
            'label' => 'attach',
            'icon' => 'attach',
            'tooltip' => 'attach',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'ui-create',
            'tooltip' => 'create',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'layout' => [
            'icon' => 'layout',
            'label' => 'layout',
            'tooltip' => 'layout',
        ],
        'delete' => [
            'icon' => 'delete',
            'label' => 'delete',
            'tooltip' => 'delete',
        ],
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'icon' => 'profile',
            'label' => 'profile',
            'tooltip' => 'profile',
        ],
        'view' => [
            'icon' => 'view',
            'tooltip' => 'view',
            'label' => 'view',
        ],
        'save' => [
            'tooltip' => 'save',
        ],
    ],
    'label' => 'tenant',
    'plural_label' => '',
];
