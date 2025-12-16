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
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo',
            'helper_text' => 'Inserisci un titolo descrittivo per questo allegato',
            'description' => 'Il titolo verrà mostrato nell\'elenco degli allegati',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'slug-del-file',
            'helper_text' => 'Identificativo univoco per il file',
            'description' => 'Lo slug verrà generato automaticamente dal titolo',
        ],
        'created_at' => [
            'label' => 'Data di creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima modifica',
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
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
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
        'layout' => [
            'label' => 'layout',
        ],
        'create' => [
            'label' => 'create',
        ],
        'description' => [
            'description' => 'description',
            'label' => 'description',
            'placeholder' => 'description',
            'helper_text' => 'description',
        ],
        'disk' => [
            'description' => 'disk',
            'label' => 'disk',
            'placeholder' => 'disk',
            'helper_text' => 'disk',
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
];
