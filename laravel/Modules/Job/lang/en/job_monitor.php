<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Monitor Jobs',
        'plural' => 'Monitor Jobs',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Manage and monitor system jobs',
        ],
        'label' => 'Monitor Jobs',
        'sort' => '72',
        'icon' => 'job-monitor-animated',
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Name of the monitored job',
            'placeholder' => 'Enter job name',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Guard associated with the job',
            'placeholder' => 'Select guard',
            'helper_text' => '',
            'description' => '',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'tooltip' => 'Permissions associated with the job',
            'placeholder' => 'Select permissions',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Updated at',
            'tooltip' => 'Date of the last update of the monitored job',
            'placeholder' => 'Update date',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Name',
            'tooltip' => 'Name of the user managing the job',
            'placeholder' => 'Manager name',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'start' => [
            'label' => 'Start',
            'modal' => [
                'heading' => 'Start Job Monitor',
                'description' => 'Do you want to start monitoring this job?',
            ],
            'messages' => [
                'success' => 'Monitoring started successfully',
            ],
            'icon' => 'play',
            'color' => 'primary',
        ],
        'pause' => [
            'label' => 'Pause',
            'modal' => [
                'heading' => 'Pause Job Monitor',
                'description' => 'Do you want to pause monitoring of this job?',
            ],
            'messages' => [
                'success' => 'Monitoring paused successfully',
            ],
            'icon' => 'pause',
            'color' => 'warning',
        ],
        'resume' => [
            'label' => 'Resume',
            'modal' => [
                'heading' => 'Resume Job Monitor',
                'description' => 'Do you want to resume monitoring of this job?',
            ],
            'messages' => [
                'success' => 'Monitoring resumed successfully',
            ],
            'icon' => 'redo',
            'color' => 'success',
        ],
        'stop' => [
            'label' => 'Stop',
            'modal' => [
                'heading' => 'Stop Job Monitor',
                'description' => 'Are you sure you want to stop monitoring this job?',
            ],
            'messages' => [
                'success' => 'Monitoring stopped successfully',
            ],
            'icon' => 'stop',
            'color' => 'danger',
        ],
    ],
    'messages' => [
        'no_jobs' => 'No jobs currently monitored',
        'job_started' => 'Job monitoring started',
        'job_paused' => 'Job monitoring paused',
        'job_resumed' => 'Job monitoring resumed',
        'job_stopped' => 'Job monitoring stopped',
    ],
    'title' => 'Job monitor',
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
