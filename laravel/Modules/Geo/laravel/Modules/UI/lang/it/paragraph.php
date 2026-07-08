<?php

declare(strict_types=1);

return [
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'description' => 'title',
            'helper_text' => 'title',
            'placeholder' => 'title',
            'tooltip' => '',
        ],
        'text' => [
            'label' => 'Testo',
            'description' => 'text',
            'helper_text' => 'text',
            'placeholder' => 'text',
            'tooltip' => '',
        ],
        '_tpl' => [
            'label' => '_tpl',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'view' => [
            'label' => 'view',
            'description' => 'view',
            'helper_text' => 'view',
            'placeholder' => 'view',
            'tooltip' => '',
        ],
    ],
    'label' => 'Paragraph',
    'plural_label' => 'Paragraph (Plurale)',
    'navigation' => [
        'name' => 'Paragraph',
        'plural' => 'Paragraph',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Paragraph',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Paragraph',
        ],
        'edit' => [
            'label' => 'Modifica Paragraph',
        ],
        'delete' => [
            'label' => 'Elimina Paragraph',
        ],
    ],
];
