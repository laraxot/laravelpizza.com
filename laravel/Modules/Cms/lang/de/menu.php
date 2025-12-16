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
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome del menu',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'Slug del menu',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Descrizione del menu',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Tipo di menu',
            'options' => [
                'main' => 'Principale',
                'footer' => 'Footer',
                'sidebar' => 'Barra laterale',
            ],
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato del menu',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'draft' => 'Bozza',
            ],
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'message' => [
            'label' => 'message',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'title' => [
            'label' => 'title',
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
];
