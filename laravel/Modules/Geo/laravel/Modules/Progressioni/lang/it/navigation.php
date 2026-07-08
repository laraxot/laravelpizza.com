<?php

declare(strict_types=1);

return [
    'group' => [
        'label' => 'Progressioni',
        'description' => 'Gestione delle progressioni di carriera',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 21,
    ],
    'resources' => [
        'progressioni' => [
            'label' => 'Progressioni',
            'plural_label' => 'Progressioni',
            'icon' => 'heroicon-o-chart-bar',
            'sort' => 1,
            'description' => 'Gestione delle progressioni di carriera del personale',
        ],
        'schede' => [
            'label' => 'Scheda Valutazione',
            'plural_label' => 'Scheda Valutazione',
            'icon' => 'heroicon-o-document-text',
            'sort' => 2,
            'description' => 'Scheda di valutazione per le progressioni',
        ],
        'criteri_valutazione' => [
            'label' => 'Criteri Valutazione',
            'plural_label' => 'Criteri Valutazione',
            'icon' => 'heroicon-o-clipboard-document-list',
            'sort' => 3,
            'description' => 'Criteri utilizzati per la valutazione delle progressioni',
        ],
        'criteri_esclusione' => [
            'label' => 'Criteri Esclusione',
            'plural_label' => 'Criteri Esclusione',
            'icon' => 'heroicon-o-x-circle',
            'sort' => 4,
            'description' => 'Criteri di esclusione dalle progressioni',
        ],
        'criteri_precedenza' => [
            'label' => 'Criteri Precedenza',
            'plural_label' => 'Criteri Precedenza',
            'icon' => 'heroicon-o-arrow-up-circle',
            'sort' => 5,
            'description' => 'Criteri di precedenza per le progressioni',
        ],
        'categoria_propro' => [
            'label' => 'Categorie Profilo Professionale',
            'plural_label' => 'Categorie Profilo Professionale',
            'icon' => 'heroicon-o-user-group',
            'sort' => 6,
            'description' => 'Categorie dei profili professionali',
        ],
        'valutatori' => [
            'label' => 'Valutatori',
            'plural_label' => 'Valutatori',
            'icon' => 'heroicon-o-users',
            'sort' => 7,
            'description' => 'Gestione dei valutatori delle progressioni',
        ],
        'pesi' => [
            'label' => 'Pesi Valutazione',
            'plural_label' => 'Pesi Valutazione',
            'icon' => 'heroicon-o-scale',
            'sort' => 8,
            'description' => 'Pesi utilizzati per la valutazione',
        ],
        'stipendio_tabellare' => [
            'label' => 'Stipendi Tabellari',
            'plural_label' => 'Stipendi Tabellari',
            'icon' => 'heroicon-o-currency-euro',
            'sort' => 9,
            'description' => 'Gestione degli stipendi tabellari',
        ],
        'stabi_dirigente' => [
            'label' => 'Stabilimenti Dirigenti',
            'plural_label' => 'Stabilimenti Dirigenti',
            'icon' => 'heroicon-o-building-office',
            'sort' => 10,
            'description' => 'Gestione stabilimenti e dirigenti',
        ],
        'assenze' => [
            'label' => 'Assenze',
            'plural_label' => 'Assenze',
            'icon' => 'heroicon-o-calendar-days',
            'sort' => 11,
            'description' => 'Gestione delle assenze del personale',
        ],
        'coeff' => [
            'label' => 'Coefficienti',
            'plural_label' => 'Coefficienti',
            'icon' => 'heroicon-o-calculator',
            'sort' => 12,
            'description' => 'Coefficienti di calcolo per le progressioni',
        ],
        'ced_diff' => [
            'label' => 'CED Differenze',
            'plural_label' => 'CED Differenze',
            'icon' => 'heroicon-o-document-duplicate',
            'sort' => 13,
            'description' => 'Gestione delle differenze CED',
        ],
        'max_cateco_posfun_anno' => [
            'label' => 'Massimi Categoria/Posizione',
            'plural_label' => 'Massimi Categoria/Posizione',
            'icon' => 'heroicon-o-chart-bar-square',
            'sort' => 14,
            'description' => 'Massimi per categoria economica e posizione funzionale per anno',
        ],
        'esclusi_extra' => [
            'label' => 'Esclusi Extra',
            'plural_label' => 'Esclusi Extra',
            'icon' => 'heroicon-o-user-minus',
            'sort' => 15,
            'description' => 'Gestione esclusioni aggiuntive',
        ],
        'my_log' => [
            'label' => 'Log Sistema',
            'plural_label' => 'Log Sistema',
            'icon' => 'heroicon-o-document-text',
            'sort' => 16,
            'description' => 'Log delle operazioni del sistema',
        ],
        'scheda_criteri' => [
            'label' => 'Scheda Criteri',
            'plural_label' => 'Scheda Criteri',
            'icon' => 'heroicon-o-clipboard-document-check',
            'sort' => 17,
            'description' => 'Scheda dei criteri di valutazione',
        ],
        'criteri_option' => [
            'label' => 'Opzioni Criteri',
            'plural_label' => 'Opzioni Criteri',
            'icon' => 'heroicon-o-cog-6-tooth',
            'sort' => 18,
            'description' => 'Opzioni di configurazione dei criteri',
        ],
        'xls_coeff' => [
            'label' => 'Coefficienti XLS',
            'plural_label' => 'Coefficienti XLS',
            'icon' => 'heroicon-o-document-arrow-down',
            'sort' => 19,
            'description' => 'Import/Export coefficienti da file XLS',
        ],
        'xls_rows' => [
            'label' => 'Righe XLS',
            'plural_label' => 'Righe XLS',
            'icon' => 'heroicon-o-table-cells',
            'sort' => 20,
            'description' => 'Gestione righe da file XLS',
        ],
    ],
    'pages' => [
        'dashboard' => [
            'label' => 'Dashboard Progressioni',
            'icon' => 'heroicon-o-chart-pie',
            'description' => 'Panoramica generale delle progressioni',
        ],
        'reports' => [
            'label' => 'Report',
            'icon' => 'heroicon-o-document-chart-bar',
            'description' => 'Report e statistiche sulle progressioni',
        ],
        'import_export' => [
            'label' => 'Import/Export',
            'icon' => 'heroicon-o-arrow-up-tray',
            'description' => 'Importazione ed esportazione dati',
        ],
        'settings' => [
            'label' => 'Impostazioni',
            'icon' => 'heroicon-o-cog-8-tooth',
            'description' => 'Configurazione del modulo progressioni',
        ],
    ],
    'widgets' => [
        'stats_overview' => [
            'label' => 'Panoramica Statistiche',
            'description' => 'Statistiche generali sulle progressioni',
        ],
        'recent_progressions' => [
            'label' => 'Progressioni Recenti',
            'description' => 'Ultime progressioni elaborate',
        ],
        'pending_evaluations' => [
            'label' => 'Valutazioni Pendenti',
            'description' => 'Valutazioni in attesa di completamento',
        ],
        'top_performers' => [
            'label' => 'Migliori Performer',
            'description' => 'Dipendenti con le migliori valutazioni',
        ],
    ],
    'tabs' => [
        'general' => [
            'label' => 'Generale',
            'description' => 'Informazioni generali',
        ],
        'details' => [
            'label' => 'Dettagli',
            'description' => 'Informazioni dettagliate',
        ],
        'evaluation' => [
            'label' => 'Valutazione',
            'description' => 'Dati di valutazione',
        ],
        'history' => [
            'label' => 'Storico',
            'description' => 'Storico delle modifiche',
        ],
        'documents' => [
            'label' => 'Documenti',
            'description' => 'Documenti allegati',
        ],
        'notes' => [
            'label' => 'Note',
            'description' => 'Note e commenti',
        ],
    ],
];
