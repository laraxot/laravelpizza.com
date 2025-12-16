<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Pagine',
        'plural' => 'Pagine',
        'group' => [
            'name' => 'Gestione Contenuti',
            'description' => 'Gestione delle pagine del sito',
        ],
        'label' => 'Pagine',
        'sort' => '5',
        'icon' => 'heroicon-o-document',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID della pagina',
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Titolo della pagina',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Slug della pagina',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Contenuto della pagina',
        ],
        'meta_title' => [
            'label' => 'Meta Titolo',
            'placeholder' => 'Meta titolo per SEO',
        ],
        'meta_description' => [
            'label' => 'Meta Descrizione',
            'placeholder' => 'Meta descrizione per SEO',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato della pagina',
            'options' => [
                'published' => 'Pubblicata',
                'draft' => 'Bozza',
                'scheduled' => 'Programmata',
                'archived' => 'Archiviata',
            ],
        ],
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Layout della pagina',
            'options' => [
                'default' => 'Predefinito',
                'full-width' => 'Larghezza piena',
                'sidebar' => 'Con barra laterale',
            ],
        ],
        'parent_id' => [
            'label' => 'Pagina Genitore',
            'placeholder' => 'Seleziona la pagina genitore',
        ],
        'order' => [
            'label' => 'Ordine',
            'placeholder' => 'Ordine di visualizzazione',
        ],
        'lang' => [
            'label' => 'Lingua',
            'placeholder' => 'Seleziona la lingua della pagina',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'placeholder' => 'Data e ora ultima modifica',
        ],
        'toggleColumns' => [
            'label' => 'Attiva/Disattiva Colonne',
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
        'create' => [
            'label' => 'create',
        ],
        'message' => [
            'label' => 'message',
        ],
        'footer_blocks' => [
            'label' => 'footer_blocks',
        ],
        'caption' => [
            'label' => 'caption',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Pagina',
        ],
        'edit' => 'Modifica Pagina',
        'delete' => 'Elimina Pagina',
        'publish' => 'Pubblica',
        'unpublish' => 'Ritira',
        'archive' => 'Archivia',
        'restore' => 'Ripristina',
        'preview' => 'Anteprima',
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
    'messages' => [
        'created' => 'Pagina creata con successo',
        'updated' => 'Pagina aggiornata con successo',
        'deleted' => 'Pagina eliminata con successo',
        'published' => 'Pagina pubblicata con successo',
        'unpublished' => 'Pagina ritirata con successo',
        'archived' => 'Pagina archiviata con successo',
        'restored' => 'Pagina ripristinata con successo',
    ],
    'validation' => [
        'title_required' => 'Der Titel ist erforderlich',
        'slug_unique' => 'Der Slug muss eindeutig sein',
        'content_required' => 'Der Inhalt ist erforderlich',
    ],
    'model' => [
        'label' => 'page.model',
    ],
];
