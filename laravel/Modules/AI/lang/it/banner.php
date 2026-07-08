<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Banner',
        'plural' => 'Banners',
        'group' => [
            'name' => 'Content',
        ],
        'sort' => 28,
        'icon' => 'heroicon-o-rectangle-stack',
        'label' => 'Banner',
    ],
    'fields' => [
        'id' => [
            'label' => 'Id',
        ],
        'title' => [
            'label' => 'Titolo',
        ],
        'category' => [
            'title' => [
                'label' => 'Categoria abbinata',
            ],
        ],
        'image' => [
            'label' => 'Immagine',
        ],
        'file' => [
            'label' => 'file',
        ],
        'fileContent' => [
            'label' => 'fileContent',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'create',
        ],
        'import' => [
            'label' => 'import',
        ],
    ],
];
