<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique identifier of the activity',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => 'Description of the activity',
        ],
        'subject_type' => [
            'label' => 'Subject Type',
            'tooltip' => 'Type of entity subject to the activity',
        ],
        'subject_id' => [
            'label' => 'Subject ID',
            'tooltip' => 'Identifier of the entity subject to the activity',
        ],
        'causer_type' => [
            'label' => 'Causer Type',
            'tooltip' => 'Type of entity that caused the activity',
        ],
        'causer_id' => [
            'label' => 'Causer ID',
            'tooltip' => 'Identifier of the entity that caused the activity',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => 'Date and time when the activity was created',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'View',
            'tooltip' => 'View activity details',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete this activity',
            'confirmation' => 'Are you sure you want to delete this activity?',
        ],
    ],
    'filters' => [
        'date' => [
            'label' => 'Date',
            'tooltip' => 'Filter by creation date',
        ],
        'type' => [
            'label' => 'Type',
            'tooltip' => 'Filter by activity type',
        ],
    ],
    'snapshots' => [
        'fields' => [
            'id' => [
                'label' => 'ID',
                'help' => 'Unique identifier of the snapshot',
            ],
            'aggregate_uuid' => [
                'label' => 'Aggregate UUID',
                'help' => 'UUID of the aggregate',
            ],
            'aggregate_version' => [
                'label' => 'Aggregate Version',
                'help' => 'Version of the aggregate',
            ],
            'state' => [
                'label' => 'State',
                'help' => 'State of the snapshot',
            ],
            'created_at' => [
                'label' => 'Creation Date',
                'help' => 'Creation date of the snapshot',
            ],
            'updated_at' => [
                'label' => 'Last Update',
                'help' => 'Last update date of the snapshot',
            ],
        ],
    ],
];
