<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Job Management',
        'plural' => 'Job Management',
        'group' => [
            'name' => 'System',
            'description' => 'Centralized management of all jobs',
        ],
        'label' => 'Job Manager',
        'sort' => '1',
        'icon' => 'job-manager-animated',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique Job Manager identifier',
            'placeholder' => 'Manager ID',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Name of the Job Manager',
            'placeholder' => 'Enter name',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => 'Brief description of the job manager',
            'placeholder' => 'Job Manager description',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Current status of the Job Manager',
            'placeholder' => 'Select status',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Type',
            'tooltip' => 'Type of Job Manager',
            'placeholder' => 'Select type',
            'helper_text' => '',
            'description' => '',
        ],
        'priority' => [
            'label' => 'Priority',
            'tooltip' => 'Execution priority of the job manager',
            'placeholder' => 'Select priority',
            'helper_text' => '',
            'description' => '',
        ],
        'max_attempts' => [
            'label' => 'Max Attempts',
            'tooltip' => 'Maximum number of attempts to run the job manager',
            'placeholder' => 'Max attempts',
            'helper_text' => '',
            'description' => '',
        ],
        'timeout' => [
            'label' => 'Timeout',
            'tooltip' => 'Maximum execution time for the job manager',
            'placeholder' => 'Timeout',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => 'Creation date of the Job Manager',
            'placeholder' => 'Creation date',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Updated At',
            'tooltip' => 'Date of last update',
            'placeholder' => 'Update date',
            'helper_text' => '',
            'description' => '',
        ],
        'last_run' => [
            'label' => 'Last Run',
            'tooltip' => 'Date and time of last execution',
            'placeholder' => 'Last run',
            'helper_text' => '',
            'description' => '',
        ],
        'next_run' => [
            'label' => 'Next Run',
            'tooltip' => 'Date and time of next execution',
            'placeholder' => 'Next run',
            'helper_text' => '',
            'description' => '',
        ],
        'cron_expression' => [
            'label' => 'Cron Expression',
            'tooltip' => 'Cron expression for job scheduling',
            'placeholder' => 'Enter cron expression',
            'helper_text' => '',
            'description' => '',
        ],
        'output' => [
            'label' => 'Output',
            'tooltip' => 'Job execution output',
            'placeholder' => 'Output',
            'helper_text' => '',
            'description' => '',
        ],
        'error' => [
            'label' => 'Error',
            'tooltip' => 'Error message if the job fails',
            'placeholder' => 'Error',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Guard associated with the Job Manager',
            'placeholder' => 'Select Guard',
            'helper_text' => '',
            'description' => '',
        ],
        'permissions' => [
            'label' => 'Permissions',
            'tooltip' => 'Permissions associated with the Job Manager',
            'placeholder' => 'Select permissions',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Name',
            'tooltip' => 'Name of the associated user',
            'placeholder' => 'Enter name',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last name',
            'tooltip' => 'Last name of the associated user',
            'placeholder' => 'Enter last name',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Import',
            'modal' => [
                'heading' => 'Import Job Manager',
                'description' => 'Select an XLS or CSV file to upload to import the Job Manager',
            ],
            'messages' => [
                'success' => 'Job Manager import started successfully',
            ],
            'icon' => 'upload',
            'color' => 'primary',
        ],
        'export' => [
            'label' => 'Export',
            'modal' => [
                'heading' => 'Export Job Manager',
                'description' => 'Export the Job Manager data to a file',
            ],
            'messages' => [
                'success' => 'Job Manager exported successfully',
            ],
            'icon' => 'download',
            'color' => 'success',
        ],
        'run' => [
            'label' => 'Esegui',
            'modal' => [
                'heading' => 'Run Job Manager',
                'description' => 'Do you want to run this Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager started successfully',
            ],
            'icon' => 'play',
            'color' => 'primary',
        ],
        'pause' => [
            'label' => 'Pause',
            'modal' => [
                'heading' => 'Metti in Pausa',
                'description' => 'Do you want to pause this Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager paused successfully',
            ],
            'icon' => 'pause',
            'color' => 'warning',
        ],
        'resume' => [
            'label' => 'Resume',
            'modal' => [
                'heading' => 'Resume Execution',
                'description' => 'Do you want to resume this Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager resumed successfully',
            ],
            'icon' => 'redo',
            'color' => 'success',
        ],
        'delete' => [
            'label' => 'Delete',
            'modal' => [
                'heading' => 'Delete Job Manager',
                'description' => 'Are you sure you want to delete this Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager deleted successfully',
            ],
            'icon' => 'trash',
            'color' => 'danger',
        ],
    ],
    'messages' => [
        'no_jobs' => 'No Job Managers found',
        'manager_started' => 'Job Manager started',
        'manager_paused' => 'Job Manager paused',
        'manager_resumed' => 'Job Manager resumed',
        'manager_completed' => 'Job Manager completed',
        'manager_failed' => 'Job Manager failed',
    ],
    'statuses' => [
        'active' => 'Attivo',
        'paused' => 'In Pausa',
        'completed' => 'Completed',
        'failed' => 'Failed',
    ],
    'types' => [
        'scheduler' => 'Schedulatore',
        'queue' => 'Coda',
        'worker' => 'Worker',
        'monitor' => 'Monitor',
    ],
    'priorities' => [
        'low' => 'Bassa',
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
