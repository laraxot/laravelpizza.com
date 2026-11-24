<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Job Batch',
        'plural' => 'Job Batches',
        'group' => [
            'name' => 'Jobs',
            'description' => 'Manage background processes',
        ],
        'label' => 'Job Batch',
        'sort' => '10',
        'icon' => 'job-batch-animated',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique job batch identifier',
            'placeholder' => 'Batch ID',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Name of the job batch',
            'placeholder' => 'Enter batch name',
            'helper_text' => '',
            'description' => '',
        ],
        'total_jobs' => [
            'label' => 'Total Jobs',
            'tooltip' => 'Total number of jobs in the batch',
            'placeholder' => 'Total number of jobs',
            'helper_text' => '',
            'description' => '',
        ],
        'pending_jobs' => [
            'label' => 'Pending Jobs',
            'tooltip' => 'Number of jobs still waiting to be processed',
            'placeholder' => 'Pending jobs',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_jobs' => [
            'label' => 'Failed Jobs',
            'tooltip' => 'Number of jobs that failed',
            'placeholder' => 'Failed jobs',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_job_ids' => [
            'label' => 'Failed Job IDs',
            'tooltip' => 'IDs of the jobs that failed',
            'placeholder' => 'Failed job IDs',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => 'Opzioni',
            'tooltip' => 'Configuration options for the job batch',
            'placeholder' => 'Select options',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => 'Job batch creation date',
            'placeholder' => 'Creation date',
            'helper_text' => '',
            'description' => '',
        ],
        'cancelled_at' => [
            'label' => 'Deleted at',
            'tooltip' => 'Batch deletion date',
            'placeholder' => 'Deletion date',
            'helper_text' => '',
            'description' => '',
        ],
        'finished_at' => [
            'label' => 'Finished at',
            'tooltip' => 'Batch end date',
            'placeholder' => 'End date',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Guard the job batch is associated with',
            'placeholder' => 'Select guard',
            'helper_text' => '',
            'description' => '',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'tooltip' => 'Permissions associated with the job batch',
            'placeholder' => 'Select permissions',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Updated at',
            'tooltip' => 'Date of the last batch update',
            'placeholder' => 'Update date',
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
    ],
    'actions' => [
        'import' => [
            'label' => 'Import',
            'modal' => [
                'heading' => 'Import Job Batch',
                'description' => 'Select an XLS or CSV file to upload to import the job batch',
            ],
            'messages' => [
                'success' => 'Job batch import started successfully',
            ],
            'icon' => 'upload',
            'color' => 'primary',
        ],
        'export' => [
            'label' => 'Export',
            'modal' => [
                'heading' => 'Export Job Batch',
                'description' => 'Export the job batch data to a file',
            ],
            'messages' => [
                'success' => 'Job batch exported successfully',
            ],
            'icon' => 'download',
            'color' => 'success',
        ],
        'retry' => [
            'label' => 'Retry',
            'modal' => [
                'heading' => 'Retry Failed Jobs',
                'description' => 'Do you want to retry the jobs that failed?',
            ],
            'messages' => [
                'success' => 'Jobs restarted successfully',
            ],
            'icon' => 'redo',
            'color' => 'warning',
        ],
        'cancel' => [
            'label' => 'Delete',
            'modal' => [
                'heading' => 'Delete Batch',
                'description' => 'Are you sure you want to delete this job batch?',
            ],
            'messages' => [
                'success' => 'Job batch deleted successfully',
            ],
            'icon' => 'trash',
            'color' => 'danger',
        ],
    ],
    'messages' => [
        'no_failed_jobs' => 'No failed jobs',
        'batch_cancelled' => 'Job batch deleted',
        'batch_finished' => 'Job batch completed',
        'batch_processing' => 'Job batch processing',
    ],
    'statuses' => [
        'pending' => 'In Attesa',
        'processing' => 'In Elaborazione',
        'completed' => 'Completed',
        'failed' => 'Failed',
        'partial' => 'Partially Completed',
    ],
    'types' => [
        'csv' => 'CSV',
        'excel' => 'Excel',
        'json' => 'JSON',
        'xml' => 'XML',
    ],
    'model' => [
        'label' => 'job batch.model',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
