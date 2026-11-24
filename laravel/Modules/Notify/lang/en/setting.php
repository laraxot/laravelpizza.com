<?php

declare(strict_types=1);

// SettingPage of the module (BaseSettingPage, Xot). Every key AutoLabelAction reads is written
// here: without it, the first render creates them with raw values.
return [
    'navigation' => [
        'label' => 'Notification Settings',
        'group' => 'Notifications',
        'icon' => 'heroicon-o-document-text',
        'sort' => 99,
    ],
    'title' => 'Notification Settings',
    'actions' => [
        'save' => [
            'label' => 'Save',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Save',
        ],
        'profile' => [
            'label' => 'Profile',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profile',
        ],
        'logout' => [
            'label' => 'Log out',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Log out',
        ],
    ],
    'fields' => [
        'cleanup_enabled' => [
            'label' => 'Automatic log cleanup',
        ],
        'cleanup_older_than_days' => [
            'label' => 'Delete logs older than (days)',
        ],
        'cleanup_batch_size' => [
            'label' => 'Deletion batch size',
        ],
        'cleanup_keep_failed' => [
            'label' => 'Keep logs of failed sends',
        ],
        'fcm_url' => [
            'label' => 'FCM endpoint',
        ],
    ],
];
