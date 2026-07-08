<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Performance Individuale',
        'plural' => 'Performance Individuali',
        'group' => 'Admin',
        'label' => 'Performance Individuale',
        'sort' => 37,
        'icon' => 'performance-individuale-outline',
    ],
    'fields' => [
        'ha_diritto' => [
            'label' => 'Ha Diritto',
            'placeholder' => 'Indica se ha diritto alla valutazione',
            'help' => 'Stato del diritto alla valutazione',
            'helper_text' => 'ha_diritto',
            'description' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'Motivo',
            'placeholder' => 'Specifica il motivo',
            'help' => 'Motivazione della valutazione',
            'helper_text' => 'motivo',
            'description' => 'motivo',
        ],
        'mail_sended_at' => [
            'label' => 'Data Invio Mail',
            'placeholder' => 'Data di invio della mail',
            'help' => 'Data in cui è stata inviata la mail di notifica',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome della performance individuale',
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
            'message' => 'Seleziona tutti gli elementi',
        ],
        'risultati_ottenuti' => 'Conseguimento degli obiettivi',
        'qualita_prestazione' => 'Monitoraggio delle attività afferenti i processi',
        'arricchimento_professionale' => 'Attuazione di strategie di miglioramento del "clima lavorativo"',
        'impegno' => 'Organizzazione della programmazione delle attività',
        'esperienza_acquisita' => 'Focalizzazione dei processi di comunicazione sulla condivisione dei risultati',
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
        'fill' => [
            'label' => 'fill',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'anno' => [
            'label' => 'anno',
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
        ],
        'al' => [
            'label' => 'al',
            'description' => 'al',
            'helper_text' => 'al',
            'placeholder' => 'al',
        ],
        'dal' => [
            'label' => 'dal',
            'description' => 'dal',
            'helper_text' => 'dal',
            'placeholder' => 'dal',
        ],
        'repar_txt' => [
            'label' => 'repar_txt',
            'description' => 'repar_txt',
            'helper_text' => 'repar_txt',
            'placeholder' => 'repar_txt',
        ],
        'repar' => [
            'label' => 'repar',
            'description' => 'repar',
            'placeholder' => 'repar',
            'helper_text' => 'repar',
        ],
        'stabi_txt' => [
            'label' => 'stabi_txt',
            'placeholder' => 'stabi_txt',
            'helper_text' => 'stabi_txt',
            'description' => 'stabi_txt',
        ],
        'stabi' => [
            'label' => 'stabi',
            'placeholder' => 'stabi',
            'helper_text' => 'stabi',
            'description' => 'stabi',
        ],
        'disci1_txt' => [
            'label' => 'disci1_txt',
            'placeholder' => 'disci1_txt',
            'helper_text' => 'disci1_txt',
            'description' => 'disci1_txt',
        ],
        'disci1' => [
            'label' => 'disci1',
            'placeholder' => 'disci1',
            'helper_text' => 'disci1',
            'description' => 'disci1',
        ],
        'cognome' => [
            'label' => 'cognome',
            'placeholder' => 'cognome',
            'helper_text' => 'cognome',
            'description' => 'cognome',
        ],
        'nome' => [
            'label' => 'nome',
            'placeholder' => 'nome',
            'helper_text' => 'nome',
            'description' => 'nome',
        ],
        'matr' => [
            'label' => 'matr',
            'placeholder' => 'matr',
            'helper_text' => 'matr',
            'description' => 'matr',
        ],
        'email' => [
            'label' => 'email',
            'placeholder' => 'email',
            'helper_text' => 'email',
            'description' => 'email',
        ],
        'totale_punteggio' => [
            'label' => 'totale_punteggio',
        ],
        'propro' => [
            'label' => 'propro',
            'placeholder' => 'propro',
            'helper_text' => 'propro',
            'description' => 'propro',
        ],
        'posfun' => [
            'label' => 'posfun',
            'placeholder' => 'posfun',
            'helper_text' => 'posfun',
            'description' => 'posfun',
        ],
        'categoria_eco' => [
            'label' => 'categoria_eco',
        ],
        'categoria_ecoval' => [
            'label' => 'categoria_ecoval',
        ],
        'posfunval' => [
            'label' => 'posfunval',
        ],
        'posiz' => [
            'label' => 'posiz',
            'placeholder' => 'posiz',
            'helper_text' => 'posiz',
            'description' => 'posiz',
        ],
        'posiz_txt' => [
            'label' => 'posiz_txt',
            'placeholder' => 'posiz_txt',
            'helper_text' => 'posiz_txt',
            'description' => 'posiz_txt',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
        ],
        'hh_assenza_dalal' => [
            'description' => 'hh_assenza_dalal',
            'helper_text' => 'hh_assenza_dalal',
            'placeholder' => 'hh_assenza_dalal',
            'label' => 'hh_assenza_dalal',
        ],
        'gg_assenza_dalal' => [
            'description' => 'gg_assenza_dalal',
            'helper_text' => 'gg_assenza_dalal',
            'placeholder' => 'gg_assenza_dalal',
            'label' => 'gg_assenza_dalal',
        ],
        'pdf' => [
            'label' => 'pdf',
        ],
        'anno_valutatore' => [
            'label' => 'anno_valutatore',
        ],
        'motivo/invio_email' => [
            'label' => 'motivo/invio_email',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'id' => [
            'label' => 'id',
            'placeholder' => 'id',
            'helper_text' => 'id',
            'description' => 'id',
        ],
        'type' => [
            'label' => 'type',
        ],
        'id/motivo' => [
            'label' => 'id/motivo',
        ],
        'criteri' => [
            'label' => 'criteri',
            'placeholder' => 'criteri',
            'helper_text' => 'criteri',
            'description' => 'criteri',
        ],
        'last_data_assunz' => [
            'label' => 'last_data_assunz',
            'placeholder' => 'last_data_assunz',
            'helper_text' => 'last_data_assunz',
            'description' => 'last_data_assunz',
        ],
        'gg_effettuati' => [
            'label' => 'gg_effettuati',
            'placeholder' => 'gg_effettuati',
            'helper_text' => 'gg_effettuati',
            'description' => 'gg_effettuati',
        ],
        'gg_assenza_anno' => [
            'label' => 'gg_assenza_anno',
            'placeholder' => 'gg_assenza_anno',
            'helper_text' => 'gg_assenza_anno',
            'description' => 'gg_assenza_anno',
        ],
        'gg_anno' => [
            'label' => 'gg_anno',
            'placeholder' => 'gg_anno',
            'helper_text' => 'gg_anno',
            'description' => 'gg_anno',
        ],
        'gg_presenza_dalal' => [
            'label' => 'gg_presenza_dalal',
            'placeholder' => 'gg_presenza_dalal',
            'helper_text' => 'gg_presenza_dalal',
            'description' => 'gg_presenza_dalal',
        ],
    ],
    'actions' => [
        'copy_from_individuale' => [
            'label' => 'Sincronizza da Individuale',
            'help' => 'Sincronizza le schede organizzative usando i dati della scheda individuale',
            'icon' => 'copy_from_individuale',
            'tooltip' => 'Aggiorna o crea le schede organizzative partendo dai dati individuali',
            'confirm' => 'Confermi la sincronizzazione dei dati da Individuale verso Organizzativa?',
        ],
        'copy_from_organizzativa' => [
            'label' => 'Copia da Organizzativa',
            'help' => 'Copia i dati dalla scheda organizzativa',
            'icon' => 'copy_from_organizzativa',
            'tooltip' => 'copy_from_organizzativa',
        ],
        'import' => [
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV',
                ],
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => [
                    'label' => 'Nome area',
                    'help' => 'Nome dell\'area di performance',
                ],
                'parent_name' => [
                    'label' => 'Area Superiore',
                    'help' => 'Nome dell\'area di livello superiore',
                ],
            ],
        ],
        'populate_year' => [
            'label' => 'populate_year',
            'icon' => 'populate_year',
            'tooltip' => 'populate_year',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'label' => 'logout',
            'icon' => 'logout',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
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
        'pdf' => [
            'label' => 'pdf',
            'icon' => 'pdf',
            'tooltip' => 'pdf',
        ],
        'fill' => [
            'label' => 'fill',
            'icon' => 'fill',
            'tooltip' => 'fill',
        ],
        'send_mail' => [
            'label' => 'send_mail',
            'icon' => 'send_mail',
            'tooltip' => 'send_mail',
        ],
        'zip_schede' => [
            'label' => 'zip_schede',
            'icon' => 'zip_schede',
            'tooltip' => 'zip_schede',
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
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
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
        'CopyFromOrganizzativa' => [
            'label' => 'CopyFromOrganizzativa',
            'icon' => 'CopyFromOrganizzativa',
            'tooltip' => 'CopyFromOrganizzativa',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'trova_esclusi' => [
            'label' => 'trova_esclusi',
            'icon' => 'trova_esclusi',
            'tooltip' => 'trova_esclusi',
        ],
        'export_xls' => [
            'label' => 'export_xls',
            'icon' => 'export_xls',
            'tooltip' => 'export_xls',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'save',
            'label' => 'save',
        ],
        'refresh' => [
            'label' => 'refresh',
            'icon' => 'refresh',
            'tooltip' => 'refresh',
        ],
        'last_data_assunz' => [
            'label' => 'last_data_assunz',
            'icon' => 'last_data_assunz',
            'tooltip' => 'last_data_assunz',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
        ],
        'gg_effettuati' => [
            'label' => 'gg_effettuati',
            'icon' => 'gg_effettuati',
            'tooltip' => 'gg_effettuati',
        ],
        'posiz' => [
            'label' => 'posiz',
            'icon' => 'posiz',
            'tooltip' => 'posiz',
        ],
        'gg_assenza_anno' => [
            'label' => 'gg_assenza_anno',
            'icon' => 'gg_assenza_anno',
            'tooltip' => 'gg_assenza_anno',
        ],
        'gg_anno' => [
            'label' => 'gg_anno',
            'icon' => 'gg_anno',
            'tooltip' => 'gg_anno',
        ],
        'export_pdf' => [
            'tooltip' => 'export_pdf',
            'label' => 'export_pdf',
            'icon' => 'export_pdf',
        ],
        'removeAllFilters' => [
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'tooltip' => 'removeAllFilters',
        ],
        'gg_presenza_dalal' => [
            'label' => 'gg_presenza_dalal',
            'icon' => 'gg_presenza_dalal',
            'tooltip' => 'gg_presenza_dalal',
        ],
        'gg_assenza_dalal' => [
            'label' => 'gg_assenza_dalal',
            'icon' => 'gg_assenza_dalal',
            'tooltip' => 'gg_assenza_dalal',
        ],
        'hh_assenza_dalal' => [
            'label' => 'hh_assenza_dalal',
            'icon' => 'hh_assenza_dalal',
            'tooltip' => 'hh_assenza_dalal',
        ],
    ],
    'messages' => [
        'import' => [
            'success' => 'Importazione completata con successo',
            'error' => 'Errore durante l\'importazione',
        ],
        'export' => [
            'success' => 'Esportazione completata con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
        'save' => [
            'success' => 'Performance individuale salvata con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Performance individuale eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'title' => 'individuale',
    'model' => [
        'label' => 'individuale.model',
    ],
    'label' => 'individuale',
    'sections' => [
        'assenze' => [
            'heading' => 'assenze',
            'label' => 'assenze',
        ],
        'periodo' => [
            'heading' => 'periodo',
            'label' => 'periodo',
        ],
        'diritto' => [
            'label' => 'diritto',
            'heading' => 'diritto',
        ],
        'lavoratore' => [
            'label' => 'lavoratore',
            'heading' => 'lavoratore',
        ],
        'qua' => [
            'label' => 'qua',
            'heading' => 'qua',
        ],
        'rep' => [
            'label' => 'rep',
            'heading' => 'rep',
        ],
        'criteri' => [
            'label' => 'criteri',
            'heading' => 'criteri',
        ],
    ],
];
