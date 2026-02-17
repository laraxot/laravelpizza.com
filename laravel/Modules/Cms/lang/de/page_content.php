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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome del contenuto',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Slug del contenuto pagina',
            'description' => 'slug',
            'helper_text' => 'slug',
            'tooltip' => '',
        ],
        'blocks' => [
            'label' => 'Blocchi',
            'placeholder' => 'Blocchi di contenuto',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'placeholder' => 'Creato da',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_by' => [
            'label' => 'Aggiornato da',
            'placeholder' => 'Aggiornato da',
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
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
