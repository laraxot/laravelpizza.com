<?php

declare(strict_types=1);

return [
    'fields' => [
        'caption' => [
            'tooltip' => '',
            'label' => 'caption',
        ],
        'alt' => [
            'tooltip' => '',
            'label' => 'alt',
        ],
        'ratio' => [
            'tooltip' => '',
            'helper_text' => '',
            'label' => 'ratio',
        ],
        'url' => [
            'tooltip' => '',
            'label' => 'url',
        ],
        'image' => [
            'label' => 'Immagine',
            'description' => 'Immagine',
            'helper_text' => 'Immagine',
            'placeholder' => 'Immagine',
            'tooltip' => '',
        ],
    ],
    'label' => 'Image',
    'plural_label' => 'Image (Plurale)',
    'navigation' => [
        'name' => 'Image',
        'plural' => 'Image',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Image',
        'sort' => 1,
        'icon' => 'heroicon-o-rectangle-stack',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Image',
        ],
        'edit' => [
            'label' => 'Modifica Image',
        ],
        'delete' => [
            'label' => 'Elimina Image',
        ],
    ],
];
