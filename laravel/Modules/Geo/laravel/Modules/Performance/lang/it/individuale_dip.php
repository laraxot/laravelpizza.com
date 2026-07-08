<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda Dipendenti',
        'plural' => 'Scheda Dipendenti',
        'group' => [
            'name' => 'Scheda',
            'description' => 'Gestione delle schede di valutazione dei dipendenti',
        ],
        'label' => 'Scheda Dipendenti',
        'sort' => 31,
        'icon' => 'performance-region-document',
    ],
    'fields' => [
        'dipendente' => [
            'label' => 'Dipendente',
            'placeholder' => 'Seleziona il dipendente',
            'help' => 'Dipendente da valutare',
        ],
        'matricola' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola',
            'help' => 'Numero di matricola del dipendente',
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
        'risultati_ottenuti' => 'Contributo al conseguimento degli obiettivi',
        'qualita_prestazione' => 'Rapporto con l\'utenza interna ed esterna',
        'arricchimento_professionale' => 'Proposte di azioni migliorative',
        'impegno' => 'Clima sociale interno',
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sulla valutazione',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
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
        'posiz' => [
            'label' => 'posiz',
            'placeholder' => 'posiz',
            'helper_text' => 'posiz',
            'description' => 'posiz',
        ],
        'posiz_txt' => [
            'label' => 'posiz_txt',
        ],
        'disci1' => [
            'label' => 'disci1',
        ],
        'disci1_txt' => [
            'label' => 'disci1_txt',
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
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
        'fill' => [
            'label' => 'compila',
            'icon' => 'performance-region-document',
        ],
        'esperienza_acquisita' => 'Gestione delle risorse',
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
        'id' => [
            'label' => 'id',
        ],
        'type' => [
            'label' => 'type',
        ],
        'id/motivo' => [
            'label' => 'id/motivo',
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
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
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
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
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
        'delete' => [
            'tooltip' => 'delete',
            'label' => 'delete',
            'icon' => 'delete',
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
        'last_data_assunz' => [
            'label' => 'last_data_assunz',
            'icon' => 'last_data_assunz',
            'tooltip' => 'last_data_assunz',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
        'export_pdf' => [
            'tooltip' => 'export_pdf',
            'label' => 'export_pdf',
            'icon' => 'export_pdf',
        ],
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'label' => 'removeAllFilters',
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
            'pending' => 'In Attesa',
            'approved' => 'Approvata',
            'rejected' => 'Rifiutata',
        ],
    ],
    'model' => [
        'label' => 'individuale dip.model',
    ],
    'label' => 'individuale dip',
];
