<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Job Status',
        'plural' => 'Job Statuses',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Monitor job status',
        ],
        'label' => 'Job Status',
        'sort' => '73',
        'icon' => 'job-status-animated',
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
            'tooltip' => 'Date of the last job status update',
            'placeholder' => 'Update date',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Name',
            'tooltip' => 'Name of the user who created or manages the job',
            'placeholder' => 'Manager name',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last name',
            'tooltip' => 'Last name of the user who created or manages the job',
            'placeholder' => 'Manager last name',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'start' => [
            'label' => 'Start',
            'modal' => [
                'heading' => 'Start Job Status',
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
                'heading' => 'Pause Job Status',
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
                'heading' => 'Resume Job Status',
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
                'heading' => 'Stop Job Status',
                'description' => 'Are you sure you want to stop monitoring this job?',
            ],
            'messages' => [
                'success' => 'Monitoring stopped successfully',
            ],
            'icon' => 'stop',
            'color' => 'danger',
        ],
        'export' => [
            'label' => 'Export',
            'modal' => [
                'heading' => 'Export Job Status Data',
                'description' => 'Select the format to export the job data',
            ],
            'messages' => [
                'success' => 'Data exported successfully',
            ],
            'icon' => 'download',
            'color' => 'info',
        ],
        'label' => 'Job Status',
        'sort' => '73',
        'icon' => 'job-status-animated',
    ],
    'messages' => [
        'no_jobs' => 'No jobs currently monitored',
        'job_started' => 'Job monitoring started',
        'job_paused' => 'Job monitoring paused',
        'job_resumed' => 'Job monitoring resumed',
        'job_stopped' => 'Job monitoring stopped',
        'job_exported' => 'Data exported successfully',
    ],
    'title' => 'Job status',
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'widget' => [
        'heading' => 'Job status',
        'queue_connection' => 'Queue connection',
        'dummy_action' => '1000 Dummy Action',
    ],
];
