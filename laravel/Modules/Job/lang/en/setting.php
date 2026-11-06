<?php

declare(strict_types=1);

// SettingPage of the module (BaseSettingPage, Xot). Every key AutoLabelAction reads is written
// here: without it, the first render creates them with raw values.
return [
    'navigation' => [
        'label' => 'Settings',
        'group' => 'Configuration',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Settings',
    'fields' => [
        'max_attempts' => [
            'label' => 'Attempts per job',
            'placeholder' => '3',
            'helper_text' => 'Passed to queue:work --tries when worker:check starts the worker. After the last attempt the job is moved to the failed jobs.',
            'tooltip' => '',
            'description' => '',
        ],
        'timeout_seconds' => [
            'label' => 'Maximum job duration (seconds)',
            'placeholder' => '60',
            'helper_text' => 'Passed to queue:work --timeout. Keep it below the retry_after of the queue connection, otherwise the same job runs twice.',
            'tooltip' => '',
            'description' => '',
        ],
        'sleep_seconds' => [
            'label' => 'Wait on an empty queue (seconds)',
            'placeholder' => '5',
            'helper_text' => 'Passed to queue:work --sleep. It only applies to a worker started by worker:check: one already running keeps its flags until it is restarted.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
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
];
