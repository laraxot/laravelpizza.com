<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'translation file.model',
    ],
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Lang',
        'icon' => 'heroicon-o-cog',
        'sort' => '23',
    ],
    'fields' => [
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'edit' => [
            'label' => 'edit',
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
    'actions' => [
        'create' => [
            'label' => 'create',
        ],
        'lang' => [
            'label' => 'lang',
        ],
    ],
];
