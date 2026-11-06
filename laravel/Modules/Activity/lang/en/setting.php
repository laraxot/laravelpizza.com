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
        'enabled' => [
            'label' => 'Record activities',
            'placeholder' => '',
            'helper_text' => 'Off: no activity is written to the log any more. Once saved, it replaces ACTIVITY_LOGGER_ENABLED.',
            'tooltip' => '',
            'description' => '',
        ],
        'clean_after_days' => [
            'label' => 'Retention in days',
            'placeholder' => '365',
            'helper_text' => 'Used by php artisan activitylog:clean, which deletes older activities. The command is not scheduled: it only runs when someone launches it.',
            'tooltip' => '',
            'description' => '',
        ],
        'default_log_name' => [
            'label' => 'Default log name',
            'placeholder' => 'default',
            'helper_text' => 'Name used when activity() is not given one. Changing it separates new activities from the ones already recorded.',
            'tooltip' => '',
            'description' => '',
        ],
        'include_soft_deleted_subjects' => [
            'label' => 'Show deleted subjects',
            'placeholder' => '',
            'helper_text' => 'On: the subject of an activity is shown even when the record was soft deleted.',
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
