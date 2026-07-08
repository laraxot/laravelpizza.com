<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Performance Amministrativa',
        'plural' => 'Performance Amministrative',
        'group' => [
            'name' => 'Admin',
            'description' => 'Gestione delle performance amministrative',
        ],
        'label' => 'Performance Amministrativa',
        'sort' => 55,
        'icon' => 'performance-individuale-outline',
    ],
    'fields' => [
        'anno' => [
            'label' => 'Anno di Riferimento',
            'placeholder' => 'Seleziona l\'anno di riferimento',
            'help' => 'Anno di riferimento per la valutazione',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola',
            'help' => 'Matricola del dipendente',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dipendente',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del dipendente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'Indirizzo email del dipendente',
        ],
        'stabi_txt' => [
            'label' => 'Valutazione Stabilità',
            'placeholder' => 'Inserisci la valutazione sulla stabilità',
            'help' => 'Valutazione complessiva della stabilità del dipendente',
        ],
        'repar_txt' => [
            'label' => 'Reparto',
            'placeholder' => 'Inserisci il testo sul reparto',
            'help' => 'Valutazione del reparto',
        ],
        'disci_txt' => [
            'label' => 'Disciplina',
            'placeholder' => 'Inserisci il testo sulla disciplina',
            'help' => 'Valutazione della disciplina',
        ],
        'categoria_eco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica di appartenenza',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome della performance amministrativa',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di protezione utilizzato',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help' => 'Permessi associati',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data ultimo aggiornamento',
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
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'help' => 'Applica i filtri selezionati',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'help' => 'Modifica l\'ordine dei record',
        ],
        'resetFilters' => [
            'label' => 'Resetta Filtri',
            'help' => 'Ripristina i filtri predefiniti',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'help' => 'Apri il pannello dei filtri',
        ],
        'value' => [
            'label' => 'value',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'totale_punteggio' => [
            'label' => 'totale_punteggio',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'create' => [
            'label' => 'create',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'importo_totale' => [
            'label' => 'importo_totale',
        ],
        'resti_pond' => [
            'label' => 'resti_pond',
        ],
        'resti' => [
            'label' => 'resti',
        ],
        'type' => [
            'label' => 'type',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
        ],
        'quota_effettiva' => [
            'label' => 'quota_effettiva',
        ],
        'budget_assegnato' => [
            'label' => 'budget_assegnato',
        ],
        'quota_teorica' => [
            'label' => 'quota_teorica',
        ],
        'hh_assenza_dalal' => [
            'label' => 'hh_assenza_dalal',
        ],
        'gg_assenza_dalal' => [
            'label' => 'gg_assenza_dalal',
        ],
        'gg_presenza_dalal' => [
            'label' => 'gg_presenza_dalal',
        ],
        'perc_parttimepond_dalal' => [
            'label' => 'perc_parttimepond_dalal',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'soldi' => [
            'label' => 'soldi',
        ],
        'info' => [
            'label' => 'info',
        ],
        'id' => [
            'label' => 'id',
        ],
        'motivo/invio_email' => [
            'label' => 'motivo/invio_email',
        ],
        'mail_sended_at' => [
            'label' => 'mail_sended_at',
        ],
        'propro' => [
            'label' => 'propro',
        ],
        'id/motivo' => [
            'label' => 'id/motivo',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => [
                    'label' => 'Seleziona un file XLS o CSV da caricare',
                    'placeholder' => '',
                    'help' => '',
                ],
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => [
                    'label' => 'Nome',
                ],
            ],
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
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
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
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
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'zip_schede' => [
            'tooltip' => 'zip_schede',
            'icon' => 'zip_schede',
            'label' => 'zip_schede',
        ],
        'populate_year' => [
            'label' => 'populate_year',
            'icon' => 'populate_year',
            'tooltip' => 'populate_year',
        ],
        'MakePdfAction' => [
            'label' => 'MakePdfAction',
            'icon' => 'MakePdfAction',
            'tooltip' => 'MakePdfAction',
        ],
        'compila' => [
            'label' => 'compila',
            'icon' => 'compila',
            'tooltip' => 'compila',
        ],
        'pdf' => [
            'label' => 'pdf',
            'icon' => 'pdf',
            'tooltip' => 'pdf',
        ],
        'send_mail' => [
            'label' => 'send_mail',
            'icon' => 'send_mail',
            'tooltip' => 'send_mail',
        ],
        'export_xls' => [
            'tooltip' => 'export_xls',
            'label' => 'export_xls',
            'icon' => 'export_xls',
        ],
        'trova_esclusi' => [
            'label' => 'trova_esclusi',
            'icon' => 'trova_esclusi',
            'tooltip' => 'trova_esclusi',
        ],
    ],
    'messages' => [
        'created' => 'Performance amministrativa creata con successo',
        'updated' => 'Performance amministrativa aggiornata con successo',
        'deleted' => 'Performance amministrativa eliminata con successo',
    ],
    'validation' => [
        'anno_required' => 'L\'anno è obbligatorio',
        'stabi_txt_required' => 'Il campo stabilità è obbligatorio',
        'repar_txt_required' => 'Il campo reparto è obbligatorio',
        'disci_txt_required' => 'Il campo disciplina è obbligatorio',
        'categoria_eco_required' => 'La categoria economica è obbligatoria',
    ],
    'model' => [
        'label' => 'Performance Amministrativa',
    ],
    'label' => 'individuale adm',
];
