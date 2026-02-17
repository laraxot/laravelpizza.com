<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Allegati',
        'group' => 'Contenuti',
        'icon' => 'heroicon-o-paper-clip',
        'sort' => 89,
    ],
    'fields' => [
        'attachment' => [
            'label' => 'File',
            'placeholder' => 'Seleziona un file',
            'helper_text' => 'Carica un nuovo file o selezionalo dalla libreria',
            'description' => 'I file supportati sono: PDF, documenti Word, Excel, immagini e archivi ZIP',
            'tooltip' => '',
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo',
            'helper_text' => 'Inserisci un titolo descrittivo per questo allegato',
            'description' => 'Il titolo verrà mostrato nell\'elenco degli allegati',
            'tooltip' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'slug-del-file',
            'helper_text' => 'Identificativo univoco per il file',
            'description' => 'Lo slug verrà generato automaticamente dal titolo',
            'tooltip' => '',
        ],
        'created_at' => [
            'label' => 'Data di creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'delete' => [
            'label' => 'delete',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'label' => 'edit',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'view' => [
            'label' => 'view',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'layout' => [
            'label' => 'layout',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'create' => [
            'label' => 'create',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'description' => 'description',
            'label' => 'description',
            'placeholder' => 'description',
            'helper_text' => 'description',
            'tooltip' => '',
        ],
        'disk' => [
            'description' => 'disk',
            'label' => 'disk',
            'placeholder' => 'disk',
            'helper_text' => 'disk',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'create' => 'Nuovo allegato',
        'edit' => 'Modifica allegato',
        'delete' => 'Elimina allegato',
        'view' => 'Visualizza allegato',
        'download' => 'Scarica file',
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
    'messages' => [
        'created' => 'Allegato creato con successo',
        'updated' => 'Allegato aggiornato con successo',
        'deleted' => 'Allegato eliminato con successo',
        'delete_confirm' => 'Sei sicuro di voler eliminare questo allegato?',
        'file_too_large' => 'Il file è troppo grande. Dimensione massima consentita: :size MB',
        'file_type_not_allowed' => 'Tipo di file non consentito',
    ],
    'filters' => [
        'search' => 'Cerca allegati...',
        'all' => 'Tutti gli allegati',
        'type' => [
            'label' => 'Tipo di file',
            'options' => [
                'all' => 'Tutti i tipi',
                'image' => 'Immagini',
                'document' => 'Documenti',
                'spreadsheet' => 'Fogli di calcolo',
                'archive' => 'Archivi',
                'other' => 'Altro',
            ],
        ],
        'date' => [
            'label' => 'Data',
            'options' => [
                'today' => 'Oggi',
                'week' => 'Questa settimana',
                'month' => 'Questo mese',
                'year' => 'Quest\'anno',
                'all' => 'Tutte le date',
            ],
        ],
    ],
    'table' => [
        'columns' => [
            'title' => 'Titolo',
            'type' => 'Tipo',
            'size' => 'Dimensione',
            'created_at' => 'Caricato il',
            'actions' => 'Azioni',
        ],
        'empty' => 'Nessun allegato trovato',
        'search' => 'Cerca allegati...',
        'actions' => [
            'edit' => 'Modifica',
            'delete' => 'Elimina',
            'download' => 'Scarica',
            'view' => 'Visualizza',
        ],
    ],
    'sections' => [
        'details' => [
            'label' => 'Dettagli allegato',
            'description' => 'Gestisci le informazioni di base dell\'allegato',
        ],
        'file' => [
            'label' => 'File',
            'description' => 'Carica o seleziona un file',
        ],
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
        ],
    ],
    'empty' => [
        'label' => 'Nessun contenuto',
        'heading' => 'Nessun allegato presente',
    ],
    'model' => [
        'label' => 'attachment.model',
    ],
    'label' => 'Attachment',
    'plural_label' => 'Attachment (Plurale)',
];
