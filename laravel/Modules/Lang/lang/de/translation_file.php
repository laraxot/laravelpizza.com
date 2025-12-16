<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'create',
        ],
        'lang' => [
            'label' => 'lang',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'edit',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'content' => [
            'description' => 'content',
            'helper_text' => 'content',
            'placeholder' => 'content',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'snapshots' => [
            'fields' => [
                'updated_at' => [
                    'help' => [
                        'description' => 'snapshots.fields.updated_at.help',
                        'helper_text' => 'snapshots.fields.updated_at.help',
                        'placeholder' => 'snapshots.fields.updated_at.help',
                        'label' => 'snapshots.fields.updated_at.help',
                    ],
                    'label' => [
                        'description' => 'snapshots.fields.updated_at.label',
                        'helper_text' => 'snapshots.fields.updated_at.label',
                        'placeholder' => 'snapshots.fields.updated_at.label',
                    ],
                ],
            ],
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'key' => [
            'label' => 'key',
        ],
    ],
    'navigation' => [
        'label' => 'Navigation Label',
        'sort' => '73',
        'icon' => 'heroicon-o-cog',
        'group' => 'Lang',
    ],
    'model' => [
        'label' => 'translation file.model',
    ],
];
