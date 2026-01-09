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
            'tooltip' => 'Identificativo unico del Job Manager',
            'placeholder' => 'ID del Manager',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Name of the Job Manager',
            'placeholder' => 'Enter name',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => 'Brief description of the job manager',
            'placeholder' => 'Job Manager description',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Current status of the Job Manager',
            'placeholder' => 'Select status',
        ],
        'type' => [
            'label' => 'Type',
            'tooltip' => 'Type of Job Manager',
            'placeholder' => 'Select type',
        ],
        'priority' => [
            'label' => 'Priority',
            'tooltip' => 'Execution priority of the job manager',
            'placeholder' => 'Select priority',
        ],
        'max_attempts' => [
            'label' => 'Max Attempts',
            'tooltip' => 'Maximum number of attempts to run the job manager',
            'placeholder' => 'Max attempts',
        ],
        'timeout' => [
            'label' => 'Timeout',
            'tooltip' => 'Maximum execution time for the job manager',
            'placeholder' => 'Timeout',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => 'Creation date of the Job Manager',
            'placeholder' => 'Creation date',
        ],
        'updated_at' => [
            'label' => 'Updated At',
            'tooltip' => 'Date of last update',
            'placeholder' => 'Update date',
        ],
        'last_run' => [
            'label' => 'Last Run',
            'tooltip' => 'Date and time of last execution',
            'placeholder' => 'Last run',
        ],
        'next_run' => [
            'label' => 'Next Run',
            'tooltip' => 'Date and time of next execution',
            'placeholder' => 'Next run',
        ],
        'cron_expression' => [
            'label' => 'Cron Expression',
            'tooltip' => 'Cron expression for job scheduling',
            'placeholder' => 'Enter cron expression',
        ],
        'output' => [
            'label' => 'Output',
            'tooltip' => 'Job execution output',
            'placeholder' => 'Output',
        ],
        'error' => [
            'label' => 'Error',
            'tooltip' => 'Error message if the job fails',
            'placeholder' => 'Error',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Guard associated with the Job Manager',
            'placeholder' => 'Select Guard',
        ],
        'permissions' => [
            'label' => 'Permissions',
            'tooltip' => 'Permissions associated with the Job Manager',
            'placeholder' => 'Select permissions',
        ],
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome dell\'utente associato',
            'placeholder' => 'Inserisci nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => 'Cognome dell\'utente associato',
            'placeholder' => 'Inserisci cognome',
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
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa',
            'modal' => [
                'heading' => 'Importa Job Manager',
                'description' => 'Seleziona un file XLS o CSV da caricare per importare il Job Manager',
            ],
            'messages' => [
                'success' => 'Importazione del Job Manager avviata con successo',
            ],
            'icon' => 'upload',
            'color' => 'primary',
        ],
        'export' => [
            'label' => 'Esporta',
            'modal' => [
                'heading' => 'Esporta Job Manager',
                'description' => 'Esporta i dati del Job Manager in un file',
            ],
            'messages' => [
                'success' => 'Job Manager esportato con successo',
            ],
            'icon' => 'download',
            'color' => 'success',
        ],
        'run' => [
            'label' => 'Esegui',
            'modal' => [
                'heading' => 'Esegui Job Manager',
                'description' => 'Vuoi eseguire questo Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager avviato con successo',
            ],
            'icon' => 'play',
            'color' => 'primary',
        ],
        'pause' => [
            'label' => 'Pausa',
            'modal' => [
                'heading' => 'Metti in Pausa',
                'description' => 'Vuoi mettere in pausa questo Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager messo in pausa con successo',
            ],
            'icon' => 'pause',
            'color' => 'warning',
        ],
        'resume' => [
            'label' => 'Riprendi',
            'modal' => [
                'heading' => 'Riprendi Esecuzione',
                'description' => 'Vuoi riprendere l\'esecuzione di questo Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager ripreso con successo',
            ],
            'icon' => 'redo',
            'color' => 'success',
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal' => [
                'heading' => 'Elimina Job Manager',
                'description' => 'Sei sicuro di voler eliminare questo Job Manager?',
            ],
            'messages' => [
                'success' => 'Job Manager eliminato con successo',
            ],
            'icon' => 'trash',
            'color' => 'danger',
        ],
    ],
    'messages' => [
        'no_jobs' => 'Nessun Job Manager presente',
        'manager_started' => 'Job Manager avviato',
        'manager_paused' => 'Job Manager in pausa',
        'manager_resumed' => 'Job Manager ripreso',
        'manager_completed' => 'Job Manager completato',
        'manager_failed' => 'Job Manager fallito',
    ],
    'statuses' => [
        'active' => 'Attivo',
        'paused' => 'In Pausa',
        'completed' => 'Completato',
        'failed' => 'Fallito',
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
];
