<?php

declare(strict_types=1);

return [
    'form' => [
        'token' => [
            'label' => 'Device token',
            'helper' => 'FCM token of the device receiving the test',
        ],
        'title' => [
            'label' => 'Title',
        ],
        'body' => [
            'label' => 'Body',
        ],
        'image_url' => [
            'label' => 'Image URL',
            'helper' => 'Optional',
        ],
        'notification_type' => [
            'label' => 'Notification type',
        ],
        'high_priority' => [
            'label' => 'High priority',
            'helper' => 'Immediate delivery even in battery saver',
        ],
        'custom_data' => [
            'label' => 'Custom data',
            'helper' => 'Key/value pairs sent with the notification',
            'key_label' => 'Key',
            'value_label' => 'Value',
        ],
    ],
    'actions' => [
        'send' => 'Send',
    ],
    'notifications' => [
        'sent' => [
            'title' => 'Notification sent',
            'body' => 'The push notification was sent',
        ],
        'error' => [
            'title' => 'Sending failed',
        ],
    ],
];
