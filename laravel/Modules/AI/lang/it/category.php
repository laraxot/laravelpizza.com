<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Category',
        'plural' => 'Categories',
        'group' => [
            'name' => 'Content',
        ],
        'sort' => 21,
        'icon' => 'heroicon-o-tag',
        'label' => 'Categoria',
    ],
    'show' => [
        'title' => 'Articoli della categoria ',
    ],
    'fields' => [
        'icon' => [
            'label' => 'icon',
            'description' => 'icon',
            'helper_text' => 'icon',
            'placeholder' => 'icon',
        ],
        'image' => [
            'label' => 'image',
            'description' => 'image',
            'helper_text' => 'image',
            'placeholder' => 'image',
        ],
        'description' => [
            'label' => 'description',
            'description' => 'description',
            'helper_text' => 'description',
            'placeholder' => 'description',
        ],
        'parent_id' => [
            'label' => 'parent_id',
            'description' => 'parent_id',
            'placeholder' => 'parent_id',
            'helper_text' => 'parent_id',
        ],
        'slug' => [
            'label' => 'slug',
            'placeholder' => 'slug',
            'helper_text' => 'slug',
            'description' => 'slug',
        ],
        'title' => [
            'label' => 'title',
            'placeholder' => 'title',
            'helper_text' => 'title',
            'description' => 'title',
        ],
        'parent' => [
            'title' => [
                'label' => 'parent.title',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'create',
        ],
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
];
