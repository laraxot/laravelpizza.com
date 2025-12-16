<?php

declare(strict_types=1);

return [
    'pages' => 'Pages',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Job',
        'plural' => 'Jobs',
        'group' => [
            'name' => 'Jobs',
            'description' => 'Background process management',
        ],
        'label' => 'jobs',
        'sort' => 30,
        'icon' => 'heroicon-o-cog',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique job identifier',
        ],
        'queue' => [
            'label' => 'Queue',
            'tooltip' => 'The queue this job belongs to',
        ],
        'payload' => [
            'label' => 'Payload',
            'tooltip' => 'Data associated with the job',
        ],
        'attempts' => [
            'label' => 'Attempts',
            'tooltip' => 'Number of attempts to execute the job',
        ],
        'reserved_at' => [
            'label' => 'Reserved at',
            'tooltip' => 'Date and time when the job was reserved',
        ],
        'available_at' => [
            'label' => 'Available at',
            'tooltip' => 'Date and time when the job became available',
        ],
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => 'Job creation date',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Current job status',
        ],
        'progress' => [
            'label' => 'Progress',
            'tooltip' => 'Job completion percentage',
        ],
        'type' => [
            'label' => 'Type',
            'tooltip' => 'Job type (e.g., import, export)',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Job name',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => 'Job description',
            'placeholder' => 'Enter a description',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Job guardian',
        ],
        'permissions' => [
            'label' => 'Permissions',
            'tooltip' => 'Permissions associated with the job',
        ],
        'updated_at' => [
            'label' => 'Updated at',
            'tooltip' => 'Date of last job update',
        ],
        'first_name' => [
            'label' => 'First Name',
            'tooltip' => 'Responsible person\'s first name',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'tooltip' => 'Responsible person\'s last name',
        ],
        'select_all' => [
            'label' => 'Select All',
            'tooltip' => 'Select all available items',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'label' => 'value',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Import',
            'tooltip' => 'Import data from a file',
            'icon' => 'import-icon',
            'color' => 'blue',
            'fields' => [
                'import_file' => [
                    'label' => 'Select an XLS or CSV file to upload',
                    'placeholder' => 'Select the file to upload',
                ],
            ],
        ],
        'export' => [
            'label' => 'Export',
            'tooltip' => 'Export data to a file',
            'icon' => 'export-icon',
            'color' => 'green',
            'filename_prefix' => 'Areas as of',
            'columns' => [
                'name' => [
                    'label' => 'Area name',
                    'tooltip' => 'Name of the area to export',
                ],
                'parent_name' => [
                    'label' => 'Parent area name',
                    'tooltip' => 'Name of the parent area',
                ],
            ],
        ],
        'run' => [
            'label' => 'Run',
            'icon' => 'play',
            'color' => 'green',
            'modal' => [
                'heading' => 'Run Job',
                'description' => 'Do you want to run this job?',
            ],
            'messages' => [
                'success' => 'Job started successfully',
            ],
        ],
        'stop' => [
            'label' => 'Stop',
            'icon' => 'pause',
            'color' => 'red',
            'modal' => [
                'heading' => 'Stop Job',
                'description' => 'Do you want to stop this job?',
            ],
            'messages' => [
                'success' => 'Job stopped successfully',
            ],
        ],
        'delete' => [
            'label' => 'Delete',
            'icon' => 'trash',
            'color' => 'red',
            'modal' => [
                'heading' => 'Delete Job',
                'description' => 'Are you sure you want to delete this job?',
            ],
            'messages' => [
                'success' => 'Job deleted successfully',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'No jobs present',
        'job_started' => 'Job started',
        'job_stopped' => 'Job stopped',
        'job_completed' => 'Job completed',
        'job_failed' => 'Job failed',
    ],
    'statuses' => [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'completed' => 'Completed',
        'failed' => 'Failed',
        'stopped' => 'Stopped',
    ],
    'types' => [
        'import' => 'Import',
        'export' => 'Export',
        'process' => 'Process',
        'notification' => 'Notification',
        'cleanup' => 'Cleanup',
    ],
];
