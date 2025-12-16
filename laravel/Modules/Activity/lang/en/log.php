<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Log',
        'plural' => 'Log',
        'group' => [
            'name' => 'Monitoring',
            'description' => 'System log management',
        ],
        'label' => 'Log',
        'sort' => '61',
        'icon' => 'activity-log-animated',
    ],
    'fields' => [
        'level' => [
            'label' => 'Level',
            'emergency' => 'Emergency',
            'alert' => 'Alert',
            'critical' => 'Critical',
            'error' => 'Error',
            'warning' => 'Warning',
            'notice' => 'Notice',
            'info' => 'Info',
            'debug' => 'Debug',
        ],
        'message' => 'Message',
        'context' => [
            'label' => 'Context',
            'exception' => 'Exception',
            'stack_trace' => 'Stack Trace',
            'additional' => 'Additional Info',
        ],
        'channel' => [
            'label' => 'Channel',
            'system' => 'System',
            'application' => 'Application',
            'security' => 'Security',
            'database' => 'Database',
            'queue' => 'Queues',
        ],
        'datetime' => 'Date and Time',
        'environment' => 'Environment',
    ],
    'filters' => [
        'level' => 'Level',
        'channel' => 'Channel',
        'date_range' => 'Date Range',
        'environment' => 'Environment',
        'search' => 'Search in message',
    ],
    'actions' => [
        'view_details' => 'View Details',
        'download' => 'Download',
        'clear' => 'Clear',
        'archive' => 'Archive',
    ],
    'messages' => [
        'no_logs' => 'No logs found',
        'cleared' => 'Logs cleared successfully',
        'archived' => 'Logs archived successfully',
        'downloaded' => 'Log file downloaded successfully',
    ],
    'badges' => [
        'level' => [
            'emergency' => 'Emergency',
            'alert' => 'Alert',
            'critical' => 'Critical',
            'error' => 'Error',
            'warning' => 'Warning',
            'notice' => 'Notice',
            'info' => 'Info',
            'debug' => 'Debug',
        ],
    ],
];
