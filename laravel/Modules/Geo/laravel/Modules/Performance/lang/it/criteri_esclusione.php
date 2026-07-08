<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Criteri di Esclusione',
        'plural' => 'Criteri di Esclusione',
        'group' => [
            'name' => 'Criteri',
            'description' => 'Gestione dei criteri di esclusione',
        ],
        'label' => 'Criteri di Esclusione',
        'sort' => 61,
        'icon' => 'performance-exclusion-outline',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del criterio di esclusione',
            'helper_text' => 'name',
            'description' => 'name',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dettagliata del criterio',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipo di esclusione',
            'options' => [
                'assenza' => 'Assenza',
                'comportamento' => 'Comportamento',
                'performance' => 'Performance',
            ],
        ],
        'attivo' => [
            'label' => 'Attivo',
            'help' => 'Indica se il criterio è attualmente in uso',
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio',
            'help' => 'Data di inizio validità',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine',
            'help' => 'Data di fine validità',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sul criterio',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'field_name' => [
            'label' => 'field_name',
            'placeholder' => 'field_name',
            'helper_text' => 'field_name',
            'description' => 'field_name',
        ],
        'op' => [
            'label' => 'op',
            'placeholder' => 'op',
            'helper_text' => 'op',
            'description' => 'op',
        ],
        'value' => [
            'label' => 'value',
            'description' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
        ],
        'anno' => [
            'label' => 'anno',
            'placeholder' => 'anno',
            'helper_text' => 'anno',
            'description' => 'anno',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'create' => [
            'label' => 'create',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'is_enabled' => [
            'label' => 'is_enabled',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Criterio',
            'success' => 'Criterio creato con successo',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Criterio aggiornato con successo',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Criterio eliminato con successo',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'label' => 'cancel',
            'icon' => 'cancel',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'CheckCriterioEsclusioneBulkAction' => [
            'label' => 'CheckCriterioEsclusioneBulkAction',
            'icon' => 'CheckCriterioEsclusioneBulkAction',
            'tooltip' => 'CheckCriterioEsclusioneBulkAction',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
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
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
    ],
    'messages' => [
        'validation' => [
            'required' => 'Campo obbligatorio',
            'date' => 'Data non valida',
            'date_after' => 'La data deve essere successiva a :date',
            'date_before' => 'La data deve essere precedente a :date',
        ],
    ],
    'model' => [
        'label' => 'criteri esclusione.model',
    ],
    'label' => 'criteri esclusione',
];
