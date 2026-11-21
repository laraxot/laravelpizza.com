<?php

declare(strict_types=1);

return [
    'navigation' => [
        'fields' => [
            'items' => [
                'label' => 'Navigation items',
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
                'label' => 'Name',
            ],
            'slug' => [
                'label' => 'Slug',
            ],
            'parent' => [
                'label' => 'Parent category',
            ],
        ],
    ],
    'post' => [
        'fields' => [
            'title' => [
                'label' => 'Title',
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
                'label' => 'Name',
            ],
            'email' => [
                'label' => 'Email',
            ],
            'phone' => [
                'label' => 'Phone',
            ],
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
