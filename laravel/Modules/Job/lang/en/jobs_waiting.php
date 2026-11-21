<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Waiting Jobs',
        'plural' => 'Waiting Jobs',
        'group' => [
            'name' => 'System',
            'description' => 'Queue job monitoring',
        ],
        'label' => 'Waiting Jobs',
        'sort' => '15',
        'icon' => 'heroicon-o-cog',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique job identifier',
            'placeholder' => 'Job ID',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Queue',
            'tooltip' => 'Name of the job queue',
            'placeholder' => 'Select queue',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Payload',
            'tooltip' => 'Data associated with the job',
            'placeholder' => 'Load job data',
            'helper_text' => '',
            'description' => '',
        ],
        'attempts' => [
            'label' => 'Attempts',
            'tooltip' => 'Number of execution attempts',
            'placeholder' => 'Attempts made',
            'helper_text' => '',
            'description' => '',
        ],
        'reserved_at' => [
            'label' => 'Reserved At',
            'tooltip' => 'Date and time when the job was reserved',
            'placeholder' => 'Select date',
            'helper_text' => '',
            'description' => '',
        ],
        'available_at' => [
            'label' => 'Available At',
            'tooltip' => 'Date and time when the job becomes available',
            'placeholder' => 'Select date',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => 'Job creation date',
            'placeholder' => 'Creation date',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Current job status',
            'placeholder' => 'Select status',
            'helper_text' => '',
            'description' => '',
        ],
        'priority' => [
            'label' => 'Priority',
            'tooltip' => 'Job priority',
            'placeholder' => 'Select priority',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Type',
            'tooltip' => 'Job type (Import, Export, etc.)',
            'placeholder' => 'Select type',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Job name',
            'placeholder' => 'Enter job name',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => 'Job description',
            'placeholder' => 'Enter description',
            'helper_text' => '',
            'description' => '',
        ],
        'delay' => [
            'label' => 'Delay',
            'tooltip' => 'Delay time before the job is executed',
            'placeholder' => 'Enter delay',
            'helper_text' => '',
            'description' => '',
        ],
        'timeout' => [
            'label' => 'Timeout',
            'tooltip' => 'Maximum job execution time',
            'placeholder' => 'Enter timeout',
            'helper_text' => '',
            'description' => '',
        ],
        'tags' => [
            'label' => 'Tags',
            'tooltip' => 'Tags associated with the job',
            'placeholder' => 'Enter tags',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'First Name',
            'tooltip' => 'User\'s first name',
            'placeholder' => 'Enter first name',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'tooltip' => 'User\'s last name',
            'placeholder' => 'Enter last name',
            'helper_text' => '',
            'description' => '',
        ],
        'select_all' => [
            'label' => 'Select all',
            'tooltip' => 'Select all available items',
            'placeholder' => '',
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
        'import' => [
            'label' => 'Import',
            'tooltip' => 'Import data from an XLS or CSV file',
            'icon' => 'import-icon',
            'color' => 'blue',
            'fields' => [
                'import_file' => [
                    'label' => 'Select an XLS or CSV file to upload',
                    'tooltip' => 'Select a file to upload for import',
                    'placeholder' => 'Choose a file',
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
        'process' => [
            'label' => 'Process',
            'tooltip' => 'Process the waiting job',
            'icon' => 'play-circle',
            'color' => 'green',
            'modal' => [
                'heading' => 'Process Job',
                'description' => 'Do you want to process this waiting job?',
            ],
            'messages' => [
                'success' => 'Job processed successfully',
            ],
        ],
        'cancel' => [
            'label' => 'Delete',
            'tooltip' => 'Delete the waiting job',
            'icon' => 'delete-icon',
            'color' => 'red',
            'modal' => [
                'heading' => 'Delete Job',
                'description' => 'Do you want to delete this waiting job?',
            ],
            'messages' => [
                'success' => 'Job deleted successfully',
            ],
        ],
        'retry' => [
            'label' => 'Retry',
            'tooltip' => 'Retry the failed job',
            'icon' => 'redo',
            'color' => 'yellow',
            'modal' => [
                'heading' => 'Retry Job',
                'description' => 'Do you want to retry this job?',
            ],
            'messages' => [
                'success' => 'Job retried successfully',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'No waiting jobs',
        'job_processed' => 'Job processed',
        'job_cancelled' => 'Job deleted',
        'job_retried' => 'Job retried',
    ],
    'statuses' => [
        'waiting' => 'In Attesa',
        'reserved' => 'Riservato',
        'delayed' => 'Ritardato',
        'ready' => 'Pronto',
    ],
    'priorities' => [
        'low' => 'Bassa',
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
    'types' => [
        'default' => 'Default',
        'scheduled' => 'Schedulato',
        'recurring' => 'Ricorrente',
        'batch' => 'Batch',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
