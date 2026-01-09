<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Schedule',
        'group' => 'Tools',
        'icon' => 'heroicon-o-calendar',
        'sort' => 31,
    ],
    'label' => 'Schedule',
    'plural_label' => 'Schedules',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'command' => [
            'label' => 'Command',
        ],
        'expression' => [
            'label' => 'Cron Expression',
        ],
        'description' => [
            'label' => 'Description',
        ],
        'timezone' => [
            'label' => 'Timezone',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'updated_at' => [
            'label' => 'Updated At',
        ],
    ],
    'actions' => [
        'run' => [
            'label' => 'Run',
        ],
        'enable' => [
            'label' => 'Enable',
        ],
        'disable' => [
            'label' => 'Disable',
        ],
    ],
];