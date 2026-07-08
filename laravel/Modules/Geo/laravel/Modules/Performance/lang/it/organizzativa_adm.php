<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Performance Org Admin',
        'plural' => 'Performance Org Admin',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Gestione amministrativa delle performance organizzative',
        ],
        'label' => 'performance_org_admin',
        'sort' => 59,
        'icon' => 'performance-admin-outline',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'placeholder' => 'Inserisci il guard',
            'help' => 'Nome del guard per i permessi',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help' => 'Permessi associati',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data di ultimo aggiornamento',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del dipendente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dipendente',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'help' => 'Seleziona tutti gli elementi',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Seleziona il file da importare (formati supportati: XLS, CSV)',
                ],
            ],
        ],
        'export' => [
            'filename_prefix' => 'Performance_Org_Admin_',
            'columns' => [
                'name' => [
                    'label' => 'Nome',
                    'help' => 'Nome dell\'elemento',
                ],
                'parent_name' => [
                    'label' => 'Nome Parent',
                    'help' => 'Nome dell\'elemento padre',
                ],
            ],
        ],
    ],
];
