<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda valutazione',
        'plural' => 'Schede valutazione',
        'label' => 'Scheda valutazione',
        'group' => [
            'name' => 'Progressioni',
            'description' => 'Gestione delle progressioni di carriera',
        ],
        'sort' => 93,
        'icon' => 'heroicon-o-document-text',
    ],
    'actions' => [
        'resetColumnManager' => [
            'label' => 'Ripristina colonne',
            'tooltip' => 'Ripristina la configurazione predefinita delle colonne della tabella',
            'icon' => 'heroicon-o-arrow-path',
        ],
        'applyTableColumnManager' => [
            'label' => 'Applica colonne',
            'tooltip' => 'Applica la configurazione delle colonne selezionate',
            'icon' => 'heroicon-o-check',
        ],
        'logout' => [
            'label' => 'Esci',
            'tooltip' => 'Disconnetti la sessione corrente',
            'icon' => 'heroicon-o-arrow-right-on-rectangle',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'label' => 'profile',
            'icon' => 'profile',
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
        'send_schede' => [
            'label' => 'send_schede',
            'icon' => 'send_schede',
            'tooltip' => 'send_schede',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
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
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'label' => 'removeAllFilters',
        ],
        'zip_schede' => [
            'tooltip' => 'zip_schede',
            'icon' => 'zip_schede',
            'label' => 'zip_schede',
        ],
        'send_mail' => [
            'tooltip' => 'send_mail',
            'label' => 'send_mail',
            'icon' => 'send_mail',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
        ],
        'populate_year' => [
            'label' => 'populate_year',
            'icon' => 'populate_year',
            'tooltip' => 'populate_year',
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
        'export_pdf' => [
            'label' => 'export_pdf',
            'icon' => 'export_pdf',
            'tooltip' => 'export_pdf',
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
    ],
    'label' => 'scheda',
    'fields' => [
        'id' => [
            'label' => 'id',
        ],
        'lavoratore' => [
            'label' => 'lavoratore',
        ],
        'matr' => [
            'label' => 'matr',
        ],
        'cognome' => [
            'label' => 'cognome',
        ],
        'nome' => [
            'label' => 'nome',
        ],
        'email' => [
            'label' => 'email',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'qua' => [
            'label' => 'qua',
        ],
        'categoria_ecoval' => [
            'label' => 'categoria_ecoval',
        ],
        'posfunval' => [
            'label' => 'posfunval',
        ],
        'disci1' => [
            'label' => 'disci1',
        ],
        'disci1_txt' => [
            'label' => 'disci1_txt',
        ],
        'rep' => [
            'label' => 'rep',
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
        'periodo' => [
            'label' => 'periodo',
        ],
        'dal' => [
            'label' => 'dal',
        ],
        'al' => [
            'label' => 'al',
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
        'anno/valutatore' => [
            'label' => 'anno/valutatore',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
            'placeholder' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
            'description' => 'valutatore_id',
        ],
        'mail_sended_at' => [
            'label' => 'mail_sended_at',
        ],
        'type' => [
            'label' => 'type',
        ],
        'id/motivo' => [
            'label' => 'id/motivo',
        ],
        'value' => [
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
        ],
        'anno_valutatore' => [
            'label' => 'anno_valutatore',
        ],
    ],
];
