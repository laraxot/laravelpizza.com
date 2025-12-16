<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Contenuti Pagina',
        'plural' => 'Contenuti Pagina',
        'group' => [
            'name' => 'Gestione Contenuti',
            'description' => 'Gestione dei contenuti delle pagine del sito',
        ],
        'label' => 'Contenuti Pagina',
        'sort' => '87',
        'icon' => 'heroicon-o-document-text',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID del contenuto pagina',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome del contenuto',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Slug del contenuto pagina',
            'description' => 'slug',
            'helper_text' => 'slug',
        ],
        'blocks' => [
            'label' => 'Blocchi',
            'placeholder' => 'Blocchi di contenuto',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'placeholder' => 'Creato da',
        ],
        'updated_by' => [
            'label' => 'Aggiornato da',
            'placeholder' => 'Aggiornato da',
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
    ],
    'actions' => [
        'view' => 'Visualizza Contenuto',
        'create' => [
            'label' => 'create',
        ],
        'edit' => 'Modifica Contenuto',
        'delete' => 'Elimina Contenuto',
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
    'messages' => [
        'created' => 'Contenuto creato con successo',
        'updated' => 'Contenuto aggiornato con successo',
        'deleted' => 'Contenuto eliminato con successo',
    ],
    'validation' => [
        'name_required' => 'Der Name ist erforderlich',
        'slug_unique' => 'Lo slug deve essere unico',
        'blocks_required' => 'I blocchi di contenuto sono obbligatori',
    ],
    'model' => [
        'label' => 'page content.model',
    ],
];
