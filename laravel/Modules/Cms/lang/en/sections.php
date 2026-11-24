<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
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
            'label' => 'CSS Classes',
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
            'label' => 'Background Color',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'text_color' => [
            'label' => 'Text Color',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'blocks' => [
        'logo' => [
            'title' => 'Logo',
            'fields' => [
                'image' => 'Image',
                'alt' => 'Alternative Text',
                'height' => 'Height',
            ],
        ],
        'navigation' => [
            'title' => 'Navigation',
            'fields' => [
                'items' => 'Voci Menu',
                'label' => 'Label',
                'url' => 'URL',
                'target' => 'Target',
                'is_active' => 'Active',
            ],
        ],
        'actions' => [
            'title' => 'Actions',
            'fields' => [
                'items' => 'Buttons',
                'label' => 'Label',
                'url' => 'URL',
                'type' => 'Type',
            ],
            'types' => [
                'primary' => 'Primary',
                'secondary' => 'Secondary',
                'outline' => 'Outline',
                'link' => 'Link',
            ],
        ],
    ],
    'sections' => [
        'info' => 'Information',
        'style' => 'Style',
        'content' => 'Contents',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'preview' => [
        'empty' => 'No content available for this section',
        'no_blocks' => 'No blocks configured for this section',
        'no_translation' => 'No translation available for the current language',
    ],
];
