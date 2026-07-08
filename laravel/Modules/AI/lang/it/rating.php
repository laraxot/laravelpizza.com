<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'id',
        ],
        'title' => [
            'label' => 'title',
        ],
        'pivot' => [
            'user' => [
                'name' => [
                    'label' => 'pivot.user.name',
                ],
            ],
        ],
        'value' => [
            'label' => 'value',
        ],
        'is_winner' => [
            'label' => 'is_winner',
        ],
        'reward' => [
            'label' => 'reward',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'create' => [
            'label' => 'create',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
];
