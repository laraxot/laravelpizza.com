<?php

declare(strict_types=1);

return [
    'navigation' => [
        'fields' => [
            'items' => [
                'label' => 'Voci di navigazione',
            ],
            'text' => [
                'label' => 'Testo link',
            ],
            'url' => [
                'label' => 'URL link',
            ],
        ],
    ],
    'category' => [
        'fields' => [
            'name' => [
                'label' => 'Nome',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'parent' => [
                'label' => 'Categoria padre',
            ],
        ],
    ],
    'post' => [
        'fields' => [
            'title' => [
                'label' => 'Titolo',
            ],
            'content' => [
                'label' => 'Contenuto',
            ],
            'image' => [
                'label' => 'Immagine',
            ],
        ],
    ],
    'contact' => [
        'fields' => [
            'name' => [
                'label' => 'Nome',
            ],
            'email' => [
                'label' => 'Email',
            ],
            'phone' => [
                'label' => 'Telefono',
            ],
        ],
    ],
];
