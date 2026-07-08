<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'System Log',
        'plural' => 'System Logs',
        'label' => 'System Logs',
        'group' => [
            'name' => 'Allowance',
            'description' => 'Responsibility allowance management',
        ],
        'sort' => 43,
        'icon' => 'heroicon-o-clipboard-document-list',
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Unique log identifier',
        ],
        'id_tbl' => [
            'label' => 'Record ID',
            'help' => 'Related record identifier',
        ],
        'tbl' => [
            'label' => 'Table',
            'help' => 'Related record table name',
        ],
        'note' => [
            'label' => 'Notes',
            'help' => 'Description of the action performed',
        ],
        'obj' => [
            'label' => 'Object',
            'help' => 'Action object',
        ],
        'act' => [
            'label' => 'Action',
            'help' => 'Type of action performed',
        ],
        'data' => [
            'label' => 'Data',
            'help' => 'Serialized operation data',
        ],
        'created_at' => [
            'label' => 'Created at',
            'help' => 'Log creation date and time',
        ],
        'created_by' => [
            'label' => 'Created by',
            'help' => 'User who generated the log',
        ],
    ],

    'actions' => [
        'view' => [
            'label' => 'View',
        ],
    ],

    'messages' => [
        'empty_state' => 'No logs found',
        'readonly_warning' => 'Logs are read-only and cannot be modified',
    ],

    'log_types' => [
        'sendMailLettF' => 'Send Mail Letter F',
        'sendMailLettI' => 'Send Mail Letter I',
        'update' => 'Record Update',
        'create' => 'Record Creation',
        'delete' => 'Record Deletion',
    ],
];
