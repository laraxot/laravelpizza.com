<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Menu',
        'plural' => 'Menu',
        'group' => [
            'name' => 'Gestione Menu',
            'description' => 'Gestione dei menu del sito',
        ],
        'label' => 'Menu',
        'sort' => '57',
        'icon' => 'heroicon-o-bars-3',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID del menu',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome del menu',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Slug del menu',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Descrizione del menu',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Tipo di menu',
            'options' => [
                'main' => 'Principale',
                'footer' => 'Footer',
                'sidebar' => 'Barra laterale',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato del menu',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'draft' => 'Bozza',
            ],
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
        'message' => [
            'label' => 'message',
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
        'applyFilters' => [
            'label' => 'applyFilters',
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
        'reorderRecords' => [
            'label' => 'reorderRecords',
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
        'title' => [
            'label' => 'title',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => 'Crea Menu',
        'edit' => 'Modifica Menu',
        'delete' => 'Elimina Menu',
        'sort' => 'Ordina Voci',
        'add_item' => 'Aggiungi Voce',
    ],
    'messages' => [
        'created' => 'Menu creato con successo',
        'updated' => 'Menu aggiornato con successo',
        'deleted' => 'Menu eliminato con successo',
        'sorted' => 'Voci del menu ordinate con successo',
        'item_added' => 'Voce aggiunta con successo',
    ],
    'validation' => [
        'name_required' => 'Der Name ist erforderlich',
        'slug_unique' => 'Lo slug deve essere unico',
        'type_in' => 'Il tipo deve essere uno tra: main, footer, sidebar',
    ],
    'model' => [
        'label' => 'menu.model',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
