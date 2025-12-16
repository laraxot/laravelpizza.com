<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => 'Nome',
        'slug' => 'Slug',
        'class' => 'Classi CSS',
        'id' => 'ID HTML',
        'background_color' => 'Colore Sfondo',
        'text_color' => 'Colore Testo',
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
];
