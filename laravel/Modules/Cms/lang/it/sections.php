<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'class' => [
            'label' => 'Classi CSS',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'label' => 'ID HTML',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'background_color' => [
            'label' => 'Colore Sfondo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'text_color' => [
            'label' => 'Colore Testo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'blocks' => [
        'logo' => [
            'title' => 'Logo',
            'fields' => [
                'image' => 'Immagine',
                'alt' => 'Testo Alternativo',
                'height' => 'Altezza',
            ],
        ],
        'navigation' => [
            'title' => 'Navigazione',
            'fields' => [
                'items' => 'Voci Menu',
                'label' => 'Etichetta',
                'url' => 'URL',
                'target' => 'Target',
                'is_active' => 'Attivo',
            ],
        ],
        'actions' => [
            'title' => 'Azioni',
            'fields' => [
                'items' => 'Bottoni',
                'label' => 'Etichetta',
                'url' => 'URL',
                'type' => 'Tipo',
            ],
            'types' => [
                'primary' => 'Primario',
                'secondary' => 'Secondario',
                'outline' => 'Outline',
                'link' => 'Link',
            ],
        ],
    ],
    'sections' => [
        'info' => 'Informazioni',
        'style' => 'Stile',
        'content' => 'Contenuti',
    ],
    'label' => 'Sections',
    'plural_label' => 'Sections (Plurale)',
    'navigation' => [
        'name' => 'Sections',
        'plural' => 'Sections',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Sections',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Sections',
        ],
        'edit' => [
            'label' => 'Modifica Sections',
        ],
        'delete' => [
            'label' => 'Elimina Sections',
        ],
    ],
];
