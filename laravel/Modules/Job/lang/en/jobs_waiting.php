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
            'tooltip' => 'Identificativo univoco del job',
            'placeholder' => 'ID del job',
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
            'label' => 'Seleziona Tutti',
            'tooltip' => 'Seleziona tutti gli elementi disponibili',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa',
            'tooltip' => 'Importa dati da un file XLS o CSV',
            'icon' => 'import-icon',
            'color' => 'blue',
            'fields' => [
                'import_file' => [
                    'label' => 'Seleziona un file XLS o CSV da caricare',
                    'tooltip' => 'Seleziona un file da caricare per l\'importazione',
                    'placeholder' => 'Scegli un file',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'tooltip' => 'Esporta i dati in un file',
            'icon' => 'export-icon',
            'color' => 'green',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => [
                    'label' => 'Nome area',
                    'tooltip' => 'Nome dell\'area da esportare',
                ],
                'parent_name' => [
                    'label' => 'Nome area livello superiore',
                    'tooltip' => 'Nome dell\'area di livello superiore',
                ],
            ],
        ],
        'process' => [
            'label' => 'Processa',
            'tooltip' => 'Processa il job in attesa',
            'icon' => 'play-circle',
            'color' => 'green',
            'modal' => [
                'heading' => 'Processa Job',
                'description' => 'Vuoi processare questo job in attesa?',
            ],
            'messages' => [
                'success' => 'Job processato con successo',
            ],
        ],
        'cancel' => [
            'label' => 'Cancella',
            'tooltip' => 'Cancella il job in attesa',
            'icon' => 'delete-icon',
            'color' => 'red',
            'modal' => [
                'heading' => 'Cancella Job',
                'description' => 'Vuoi cancellare questo job in attesa?',
            ],
            'messages' => [
                'success' => 'Job cancellato con successo',
            ],
        ],
        'retry' => [
            'label' => 'Riprova',
            'tooltip' => 'Riprova il job fallito',
            'icon' => 'redo',
            'color' => 'yellow',
            'modal' => [
                'heading' => 'Riprova Job',
                'description' => 'Vuoi riprovare questo job?',
            ],
            'messages' => [
                'success' => 'Job riprovato con successo',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'Nessun job in attesa',
        'job_processed' => 'Job processato',
        'job_cancelled' => 'Job cancellato',
        'job_retried' => 'Job riprovato',
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
