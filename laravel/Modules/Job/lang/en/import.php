<?php

declare(strict_types=1);

return [
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Importazione',
        'plural' => 'Importazioni',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Manage data imports',
        ],
        'label' => 'Data Import',
        'sort' => '10',
        'icon' => 'job-import',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique import identifier',
            'placeholder' => 'ID Importazione',
            'helper_text' => '',
            'description' => '',
        ],
        'file' => [
            'label' => 'File',
            'tooltip' => 'Select the file to import',
            'placeholder' => 'Choose a file',
            'helper_text' => '',
            'description' => '',
        ],
        'source' => [
            'label' => 'Source',
            'tooltip' => 'Indicates the source of the imported file',
            'placeholder' => 'File source',
            'helper_text' => '',
            'description' => '',
        ],
        'format' => [
            'label' => 'Format',
            'tooltip' => 'Format of the imported file (CSV, Excel, etc.)',
            'placeholder' => 'Select format',
            'helper_text' => '',
            'description' => '',
        ],
        'rows' => [
            'label' => 'Rows',
            'tooltip' => 'Total number of rows in the file',
            'placeholder' => 'Number of rows',
            'helper_text' => '',
            'description' => '',
        ],
        'processed' => [
            'label' => 'Processed Rows',
            'tooltip' => 'Number of rows processed successfully',
            'placeholder' => 'Processed rows',
            'helper_text' => '',
            'description' => '',
        ],
        'failed' => [
            'label' => 'Failed Rows',
            'tooltip' => 'Number of rows that caused errors during import',
            'placeholder' => 'Failed rows',
            'helper_text' => '',
            'description' => '',
        ],
        'started_at' => [
            'label' => 'Started at',
            'tooltip' => 'Import start date and time',
            'placeholder' => 'Import start date',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Completed at',
            'tooltip' => 'Import completion date and time',
            'placeholder' => 'Import completion date',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => 'Opzioni',
            'tooltip' => 'Advanced import settings',
            'placeholder' => 'Select options',
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
    'formats' => [
        'csv' => 'CSV',
        'excel' => 'Excel',
        'json' => 'JSON',
        'xml' => 'XML',
    ],
    'options' => [
        'headers' => 'First row contains headers',
        'delimiter' => 'Delimitatore',
        'encoding' => 'Codifica',
        'sheet' => 'Worksheet',
        'chunk_size' => 'Dimensione chunk',
    ],
    'actions' => [
        'upload' => [
            'label' => 'Upload File',
            'modal' => [
                'heading' => 'Upload a file to import',
                'description' => 'Select a file from your computer',
            ],
            'messages' => [
                'success' => 'File uploaded successfully',
            ],
            'icon' => 'upload',
            'color' => 'primary',
        ],
        'start' => [
            'label' => 'Start Import',
            'modal' => [
                'heading' => 'Start Import',
                'description' => 'Start the import of the selected file',
            ],
            'messages' => [
                'success' => 'Import started successfully',
            ],
            'icon' => 'play-circle',
            'color' => 'success',
        ],
        'download_template' => [
            'label' => 'Download Template',
            'modal' => [
                'heading' => 'Download Template',
                'description' => 'Download the template to upload data',
            ],
            'messages' => [
                'success' => 'Template downloaded successfully',
            ],
            'icon' => 'file-download',
            'color' => 'info',
        ],
        'download_failed' => [
            'label' => 'Download Failed Rows',
            'modal' => [
                'heading' => 'Download Failed Rows',
                'description' => 'Download a file with all rows that caused errors',
            ],
            'messages' => [
                'success' => 'Failed rows downloaded successfully',
            ],
            'icon' => 'download-error',
            'color' => 'danger',
        ],
        'import' => [
            'label' => 'Import',
            'modal' => [
                'heading' => 'Import Data',
                'description' => 'Select a file to import',
            ],
            'messages' => [
                'success' => 'Import started successfully',
            ],
            'fields' => [
                'import_file' => [
                    'label' => 'Select an XLS or CSV file to upload',
                    'tooltip' => 'Select the file you want to import',
                    'placeholder' => 'Upload an XLS or CSV file',
                ],
            ],
            'icon' => 'import',
            'color' => 'primary',
        ],
        'retry' => [
            'label' => 'Retry',
            'modal' => [
                'heading' => 'Retry Import',
                'description' => 'Do you want to retry importing the failed rows?',
            ],
            'messages' => [
                'success' => 'Import retried successfully',
            ],
            'icon' => 'redo',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Delete',
            'modal' => [
                'heading' => 'Delete Import',
                'description' => 'Are you sure you want to delete this import?',
            ],
            'messages' => [
                'success' => 'Import deleted successfully',
            ],
            'icon' => 'trash',
            'color' => 'danger',
        ],
        'download_errors' => [
            'label' => 'Download Errors',
            'modal' => [
                'heading' => 'Download Error Log',
                'description' => 'Do you want to download the import error log?',
            ],
            'messages' => [
                'success' => 'Error log downloaded successfully',
            ],
            'icon' => 'file-text',
            'color' => 'secondary',
        ],
        'export' => [
            'filename_prefix' => 'Areas as of',
            'columns' => [
                'name' => 'Area name',
                'parent_name' => 'Parent area name',
            ],
        ],
    ],
    'messages' => [
        'no_imports' => 'No imports found',
        'upload_success' => 'File uploaded successfully',
        'import_started' => 'Importazione avviata',
        'import_completed' => 'Importazione completata',
        'import_failed' => 'Importazione fallita',
        'file_not_found' => 'File not found',
        'invalid_format' => 'Invalid format',
        'row_error' => 'Error at row :row: :message',
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
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
