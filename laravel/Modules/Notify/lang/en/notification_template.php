<?php

declare(strict_types=1);


return [
    'navigation' => [
        'icon' => 'heroicon-o-document-text',
        'label' => 'Notification Templates',
        'group' => 'System',
        'sort' => '52',
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'helper' => 'Unique template name',
        ],
        'subject' => [
            'label' => 'Subject',
            'helper' => 'Notification subject',
        ],
        'type' => [
            'label' => 'Type',
            'helper' => 'Notification type',
        ],
        'body_text' => [
            'label' => 'Plain Text',
            'helper' => 'Plain text version of the notification',
        ],
        'body_html' => [
            'label' => 'HTML',
            'helper' => 'HTML version of the notification',
        ],
        'preview_data' => [
            'label' => 'Preview Data',
            'helper' => 'JSON data for preview',
        ],
    ],
    'columns' => [
        'name' => 'Name',
        'subject' => 'Subject',
        'type' => 'Type',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'actions' => [
        'preview' => 'Preview',
    ],
    'enums' => [
        'notification_type' => [
            'email' => 'Email',
            'sms' => 'SMS',
            'push' => 'Push Notification',
        ],
    ],
];
