<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Carica',
        'group' => '',
        'icon' => 'indennitacondizionilavoro-upload-animated',
        'sort' => 50,
    ],
    'page' => [
        'title' => 'Caricamento File',
        'heading' => 'Carica documenti',
        'description' => 'Gestisci il caricamento dei documenti relativi alle condizioni di lavoro',
    ],
    'fields' => [
        'file' => [
            'label' => 'File',
            'placeholder' => 'Seleziona un file',
            'help' => 'Formati supportati: PDF, DOC, DOCX, XLS, XLSX (max 10MB)',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione per il file',
            'help' => 'Breve descrizione del contenuto del documento',
        ],
        'category' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona una categoria',
            'help' => 'Categoria del documento per facilitarne la ricerca',
        ],
        'date' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona una data',
            'help' => 'Data di riferimento del documento',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'note' => [
            'description' => 'note',
        ],
    ],
    'actions' => [
        'upload' => [
            'label' => 'Carica file',
            'success' => 'File caricato con successo',
            'error' => 'Errore durante il caricamento del file',
        ],
        'download' => [
            'label' => 'Scarica',
            'success' => 'File scaricato con successo',
            'error' => 'Errore durante il download del file',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'File eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del file',
            'confirmation' => 'Sei sicuro di voler eliminare questo file?',
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
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
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
        ],
    ],
    'validation' => [
        'max_size' => 'Il file non può superare i 10MB',
        'mime_types' => 'Formato file non supportato. Formati supportati: PDF, DOC, DOCX, XLS, XLSX',
        'required' => 'È necessario selezionare un file',
    ],
    'messages' => [
        'processing' => 'Elaborazione in corso...',
        'no_files' => 'Non ci sono file caricati',
        'file_details' => 'Dettagli file',
        'upload_instructions' => 'Trascina i file qui o clicca per selezionarli',
    ],
    'label' => 'upload',
];
