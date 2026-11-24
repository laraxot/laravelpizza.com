<?php

declare(strict_types=1);

return [
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Failed Import Jobs',
        'plural' => 'Failed Import Jobs',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Manage and recover failed jobs',
        ],
        'label' => 'Failed Import Jobs',
        'sort' => '93',
        'icon' => 'job-failed-job',
    ],
    'model' => [
        'label' => 'Failed Job',
        'plural' => [
            'label' => 'Failed Jobs',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'uuid' => [
            'label' => 'UUID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Connessione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Coda',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Payload',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exception' => [
            'label' => 'Eccezione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => 'Failed at',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'attempts' => [
            'label' => 'Tentativi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'max_attempts' => [
            'label' => 'Tentativi Massimi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Updated at',
            'tooltip' => '',
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
    ],
    'actions' => [
        'retry' => [
            'label' => 'Retry',
            'modal' => [
                'heading' => 'Retry Job',
                'description' => 'Do you want to retry this job?',
            ],
            'messages' => [
                'success' => 'Job restarted successfully',
                'error' => 'Error while restarting the job',
            ],
        ],
        'retry_all' => [
            'label' => 'Retry All',
            'modal' => [
                'heading' => 'Retry All Jobs',
                'description' => 'Do you want to retry all failed jobs?',
            ],
            'messages' => [
                'success' => 'Jobs restarted successfully',
                'error' => 'Error while restarting the jobs',
            ],
        ],
        'delete' => [
            'label' => 'Delete',
            'modal' => [
                'heading' => 'Delete Job',
                'description' => 'Are you sure you want to delete this failed job?',
            ],
            'messages' => [
                'success' => 'Job deleted successfully',
                'error' => 'Error while deleting the job',
            ],
        ],
        'delete_all' => [
            'label' => 'Delete All',
            'modal' => [
                'heading' => 'Delete All Jobs',
                'description' => 'Are you sure you want to delete all failed jobs?',
            ],
            'messages' => [
                'success' => 'Jobs deleted successfully',
                'error' => 'Error while deleting the jobs',
            ],
        ],
        'clear' => [
            'label' => 'Pulisci Tutto',
            'modal' => [
                'heading' => 'Clear Failed Jobs',
                'description' => 'Are you sure you want to delete all failed jobs?',
            ],
            'messages' => [
                'success' => 'Jobs cleared successfully',
                'error' => 'Error while clearing the jobs',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'No failed jobs found',
        'import_success' => 'Import completed successfully',
        'import_error' => 'Error during import',
        'row_error' => 'Error at row :row: :error',
    ],
    'status' => [
        'pending' => 'In attesa',
        'processing' => 'In elaborazione',
        'failed' => 'Failed',
        'completed' => 'Completed',
    ],
    'error_types' => [
        'max_attempts' => 'Tentativi Massimi Superati',
        'timeout' => 'Timeout',
        'memory_limit' => 'Limite Memoria Superato',
        'connection' => 'Connection Error',
        'queue' => 'Queue Error',
        'payload' => 'Payload Error',
        'system' => 'System Error',
    ],
    'plural' => [
        'model' => [
            'label' => 'failed job.plural.model',
        ],
        'label' => 'Failed Jobs',
        'sort' => '93',
        'icon' => 'job-failed-job',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
