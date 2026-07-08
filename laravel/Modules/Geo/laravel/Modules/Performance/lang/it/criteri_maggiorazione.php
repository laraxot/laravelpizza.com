<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Criteri di Maggiorazione',
        'plural' => 'Criteri di Maggiorazione',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Gestione dei criteri di maggiorazione',
        ],
        'label' => 'Criteri di Maggiorazione',
        'sort' => 62,
        'icon' => 'performance-criteria-outline',
    ],
    'fields' => [
        'anno' => [
            'label' => 'Anno',
        ],
        'min_valutaz_perf_ind' => [
            'label' => 'Valutazione Performance Individuale Minima',
        ],
        'maggiorazione_perc' => [
            'label' => 'Percentuale Maggiorazione',
        ],
        'created_by' => [
            'label' => 'Creato da',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del criterio di maggiorazione',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dettagliata del criterio',
        ],
        'percentuale' => [
            'label' => 'Percentuale',
            'placeholder' => 'Inserisci la percentuale',
            'help' => 'Percentuale di maggiorazione',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipo di maggiorazione',
            'options' => [
                'responsabilita' => 'Responsabilità',
                'complessita' => 'Complessità',
                'rischio' => 'Rischio',
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
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
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
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
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
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
    ],
    'messages' => [
        'validation' => [
            'required' => 'Campo obbligatorio',
            'numeric' => 'Il valore deve essere numerico',
            'min' => 'Il valore minimo è :min',
            'max' => 'Il valore massimo è :max',
            'date' => 'Data non valida',
            'date_after' => 'La data deve essere successiva a :date',
            'date_before' => 'La data deve essere precedente a :date',
        ],
    ],
    'label' => 'criteri maggiorazione',
];
