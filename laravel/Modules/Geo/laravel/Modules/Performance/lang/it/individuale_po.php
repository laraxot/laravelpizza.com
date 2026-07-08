<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda PO',
        'plural' => 'Scheda PO',
        'group' => [
            'name' => 'Scheda',
            'description' => 'Gestione delle schede di valutazione delle Posizioni Organizzative',
        ],
        'label' => 'Scheda PO',
        'sort' => 32,
        'icon' => 'performance-region-document',
    ],
    'fields' => [
        'posizione' => [
            'label' => 'Posizione Organizzativa',
            'placeholder' => 'Seleziona la PO',
            'help' => 'Posizione Organizzativa da valutare',
        ],
        'responsabile' => [
            'label' => 'Responsabile',
            'placeholder' => 'Seleziona il responsabile',
            'help' => 'Responsabile della posizione organizzativa',
        ],
        'periodo' => [
            'label' => 'Periodo',
            'placeholder' => 'Seleziona il periodo',
            'help' => 'Periodo di valutazione',
            'options' => [
                'mensile' => 'Mensile',
                'trimestrale' => 'Trimestrale',
                'semestrale' => 'Semestrale',
                'annuale' => 'Annuale',
            ],
        ],
        'risultati_ottenuti' => 'Conseguimento degli obiettivi',
        'qualita_prestazione' => 'Monitoraggio delle attività afferenti i processi',
        'arricchimento_professionale' => 'Attuazione di strategie di miglioramento del "clima lavorativo"',
        'impegno' => 'Organizzazione della programmazione delle attività',
        'esperienza_acquisita' => 'Focalizzazione dei processi di comunicazione sulla condivisione dei risultati',
        'punteggio_totale' => [
            'label' => 'Punteggio Totale',
            'help' => 'Punteggio complessivo della valutazione',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'mail_sended_at' => [
            'label' => 'mail_sended_at',
        ],
        'cognome' => [
            'label' => 'cognome',
        ],
        'nome' => [
            'label' => 'nome',
        ],
        'matr' => [
            'label' => 'matr',
        ],
        'email' => [
            'label' => 'email',
        ],
        'totale_punteggio' => [
            'label' => 'totale_punteggio',
        ],
        'propro' => [
            'label' => 'propro',
        ],
        'posfun' => [
            'label' => 'posfun',
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
        'stabi' => [
            'label' => 'stabi',
        ],
        'stabi_txt' => [
            'label' => 'stabi_txt',
        ],
        'repar' => [
            'label' => 'repar',
        ],
        'repar_txt' => [
            'label' => 'repar_txt',
        ],
        'dal' => [
            'label' => 'dal',
        ],
        'al' => [
            'label' => 'al',
        ],
        'anno' => [
            'label' => 'anno',
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
        'fill' => [
            'label' => 'fill',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
        ],
        'pdf' => [
            'label' => 'pdf',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'anno_valutatore' => [
            'label' => 'anno_valutatore',
        ],
        'motivo/invio_email' => [
            'label' => 'motivo/invio_email',
        ],
        'value' => [
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
        ],
        'id/motivo' => [
            'label' => 'id/motivo',
        ],
        'id' => [
            'label' => 'id',
        ],
        'type' => [
            'label' => 'type',
        ],
        'gg_anno' => [
            'label' => 'gg_anno',
            'placeholder' => 'gg_anno',
            'helper_text' => 'gg_anno',
            'description' => 'gg_anno',
        ],
        'gg_effettuati' => [
            'label' => 'gg_effettuati',
            'placeholder' => 'gg_effettuati',
            'helper_text' => 'gg_effettuati',
            'description' => 'gg_effettuati',
        ],
        'posiz' => [
            'label' => 'posiz',
            'placeholder' => 'posiz',
            'helper_text' => 'posiz',
            'description' => 'posiz',
        ],
        'gg_assenza_anno' => [
            'label' => 'gg_assenza_anno',
            'placeholder' => 'gg_assenza_anno',
            'helper_text' => 'gg_assenza_anno',
            'description' => 'gg_assenza_anno',
        ],
        'last_data_assunz' => [
            'label' => 'last_data_assunz',
            'placeholder' => 'last_data_assunz',
            'helper_text' => 'last_data_assunz',
            'description' => 'last_data_assunz',
        ],
    ],
    'actions' => [
        'evaluate' => [
            'label' => 'Valuta',
            'success' => 'Valutazione completata con successo',
        ],
        'approve' => [
            'label' => 'Approva',
            'success' => 'Valutazione approvata con successo',
        ],
        'reject' => [
            'label' => 'Rifiuta',
            'success' => 'Valutazione rifiutata',
        ],
        'calculate' => [
            'label' => 'Calcola Punteggio',
            'success' => 'Punteggio calcolato con successo',
        ],
        'copy_from_organizzativa' => [
            'label' => 'copy_from_organizzativa',
            'icon' => 'copy_from_organizzativa',
            'tooltip' => 'copy_from_organizzativa',
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
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'tooltip' => 'resetFilters',
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'tooltip' => 'applyFilters',
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'tooltip' => 'openFilters',
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'label' => 'cancel',
            'icon' => 'cancel',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
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
        'MakePdfAction' => [
            'label' => 'MakePdfAction',
            'icon' => 'MakePdfAction',
            'tooltip' => 'MakePdfAction',
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
        'last_data_assunz' => [
            'tooltip' => 'last_data_assunz',
            'icon' => 'last_data_assunz',
            'label' => 'last_data_assunz',
        ],
        'export_pdf' => [
            'label' => 'export_pdf',
            'icon' => 'export_pdf',
            'tooltip' => 'export_pdf',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
        ],
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
        ],
        'gg_anno' => [
            'label' => 'gg_anno',
            'icon' => 'gg_anno',
            'tooltip' => 'gg_anno',
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
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
    ],
    'messages' => [
        'validation' => [
            'required' => 'Campo obbligatorio',
            'numeric' => 'Il valore deve essere numerico',
            'min' => 'Il valore minimo è :min',
            'max' => 'Il valore massimo è :max',
        ],
        'status' => [
            'draft' => 'Bozza',
            'pending' => 'In Attesa di Approvazione',
            'approved' => 'Approvata',
            'rejected' => 'Rifiutata',
        ],
    ],
    'model' => [
        'label' => 'individuale po.model',
    ],
    'label' => 'individuale po',
];
