<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Estrazione ZIP',
        'group' => 'Sigma',
        'icon' => 'heroicon-o-document-arrow-up',
        'sort' => 10,
    ],
    'page' => [
        'title' => 'Estrazione File ZIP',
        'heading' => 'Estrai contenuto da file ZIP',
        'description' => 'Carica e estrai il contenuto di un file ZIP dal disco di storage specificato.',
    ],
    'fields' => [
        'disk' => [
            'label' => 'Disco di Storage',
            'placeholder' => 'Inserisci il nome del disco (es. cache, local, public)',
            'help' => 'Il disco di storage dove si trova il file ZIP da estrarre',
            'description' => 'Specifica il disco di storage configurato in config/filesystems.php',
            'helper_text' => 'disk',
        ],
        'path' => [
            'label' => 'Percorso File ZIP',
            'placeholder' => 'Inserisci il percorso del file ZIP (es. PTV_Asz00f.zip)',
            'help' => 'Il percorso relativo del file ZIP all\'interno del disco specificato',
            'description' => 'Il file ZIP deve essere presente nel disco di storage indicato',
            'helper_text' => 'path',
        ],
    ],
    'actions' => [
        'extract' => [
            'label' => 'Estrai ZIP',
            'icon' => 'heroicon-o-document-arrow-down',
            'color' => 'primary',
            'tooltip' => 'Estrai il contenuto del file ZIP',
            'success' => 'File estratti con successo',
            'error' => 'Errore durante l\'estrazione del file ZIP',
        ],
        'save' => [
            'label' => 'save',
        ],
    ],
    'messages' => [
        'extraction_success' => [
            'title' => 'Estrazione completata',
            'body' => 'File estratti con successo nella directory: :path',
        ],
        'extraction_error' => [
            'title' => 'Errore di estrazione',
            'body' => 'Si è verificato un errore durante l\'estrazione: :error',
        ],
        'invalid_zip' => [
            'title' => 'File non valido',
            'body' => 'Il file specificato non è un file ZIP valido: :path',
        ],
        'zip_open_error' => [
            'title' => 'Errore apertura ZIP',
            'body' => 'Impossibile aprire il file ZIP. Verifica che il file sia corrotto o protetto da password.',
        ],
        'file_not_found' => [
            'title' => 'File non trovato',
            'body' => 'Il file ZIP non è stato trovato nel percorso specificato: :path',
        ],
    ],
    'validation' => [
        'disk_required' => 'Il disco di storage è obbligatorio',
        'path_required' => 'Il percorso del file ZIP è obbligatorio',
        'disk_exists' => 'Il disco di storage specificato non esiste',
        'file_exists' => 'Il file ZIP non esiste nel percorso specificato',
    ],
];
