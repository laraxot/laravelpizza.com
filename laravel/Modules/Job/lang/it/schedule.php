<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Schedulatore',
        'plural' => 'Schedulatori',
        'group' => [
            'name' => 'Jobs',
            'description' => 'Gestione dei job schedulati',
        ],
        'label' => 'Schedulatore',
        'sort' => 55,
        'icon' => 'job-schedule-animated',
    ],
    'resource' => [
        'single' => 'Schedule',
        'plural' => 'Schedules',
        'navigation' => 'Settings',
        'history' => 'Show run history',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Inserisci il nome del job programmato',
            'placeholder' => 'Nome del job',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Seleziona il guardiano per il job',
            'placeholder' => 'Nome del guardiano',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'tooltip' => 'Assegna i permessi necessari al job',
            'placeholder' => 'Permessi',
        ],
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del responsabile',
            'placeholder' => 'Nome responsabile',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => 'Cognome del responsabile',
            'placeholder' => 'Cognome responsabile',
        ],
        'command' => [
            'label' => 'Command',
            'tooltip' => 'Inserisci il comando da eseguire',
            'placeholder' => 'Comando',
        ],
        'arguments' => [
            'label' => 'Arguments',
            'tooltip' => 'Specificare eventuali argomenti per il comando',
            'placeholder' => 'Argomenti',
        ],
        'options' => [
            'label' => 'Options',
            'tooltip' => 'Inserisci eventuali opzioni per il comando',
            'placeholder' => 'Opzioni',
        ],
        'expression' => [
            'label' => 'Cron Expression',
            'tooltip' => 'Imposta l\'espressione cron per la pianificazione',
            'placeholder' => 'Espressione Cron',
        ],
        'log_filename' => [
            'label' => 'Log Filename',
            'tooltip' => 'Nome del file di log',
            'placeholder' => 'Log filename',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Stato corrente del job',
            'placeholder' => 'Stato',
        ],
        'actions' => [
            'label' => 'Actions',
            'tooltip' => 'Azioni disponibili per il job',
            'icon' => 'action-icon',
            'color' => 'blue',
        ],
        'run_in_background' => [
            'label' => 'Run in Background',
            'tooltip' => 'Esegui il job in background',
            'placeholder' => 'Run in background',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => 'Data di creazione del job',
            'placeholder' => 'Data creazione',
        ],
        'updated_at' => [
            'label' => 'Updated At',
            'tooltip' => 'Ultima data di aggiornamento',
            'placeholder' => 'Data aggiornamento',
        ],
        'timezone' => [
            'label' => 'Fuso Orario',
            'tooltip' => 'Imposta il fuso orario per il job',
            'placeholder' => 'Fuso orario',
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
    ],
    'messages' => [
        'no-records-found' => 'No records found.',
        'save-success' => 'Data saved successfully.',
        'save-error' => 'Error saving data.',
        'timezone' => 'All schedules will be executed in the timezone: ',
        'select' => 'Select a command',
        'custom' => 'Custom Command',
        'custom-command-here' => 'Custom Command here (e.g. `cat /proc/cpuinfo` or `artisan db:migrate`)',
    ],
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'trashed' => 'Trashed',
        'running' => 'In Esecuzione',
        'failed' => 'Fallito',
    ],
    'buttons' => [
        'inactivate' => [
            'label' => 'Inactivate',
            'icon' => 'icon-inactivate',
            'color' => 'gray',
        ],
        'activate' => [
            'label' => 'Activate',
            'icon' => 'icon-activate',
            'color' => 'green',
        ],
        'history' => [
            'label' => 'History',
            'icon' => 'icon-history',
            'color' => 'purple',
        ],
        'run' => [
            'label' => 'Esegui Ora',
            'modal' => [
                'heading' => 'Esegui Schedule',
                'description' => 'Vuoi eseguire questo schedule ora?',
            ],
            'messages' => [
                'success' => 'Schedule eseguito con successo',
            ],
            'icon' => 'icon-run',
            'color' => 'blue',
        ],
        'toggle' => [
            'label' => 'Attiva/Disattiva',
            'modal' => [
                'heading' => 'Modifica Stato',
                'description' => 'Vuoi modificare lo stato di questo schedule?',
            ],
            'messages' => [
                'success' => 'Stato modificato con successo',
            ],
            'icon' => 'icon-toggle',
            'color' => 'orange',
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal' => [
                'heading' => 'Elimina Schedule',
                'description' => 'Sei sicuro di voler eliminare questo schedule?',
            ],
            'messages' => [
                'success' => 'Schedule eliminato con successo',
            ],
            'icon' => 'icon-delete',
            'color' => 'red',
        ],
    ],
    'validation' => [
        'cron' => 'The field must be filled in the cron expression format.',
        'regex' => 'The :attribute field must only contain letters, numbers, dashes, and underscores. Comma is also allowed.',
    ],
    'frequencies' => [
        'everyMinute' => 'Ogni Minuto',
        'everyFiveMinutes' => 'Ogni 5 Minuti',
        'everyTenMinutes' => 'Ogni 10 Minuti',
        'everyFifteenMinutes' => 'Ogni 15 Minuti',
        'everyThirtyMinutes' => 'Ogni 30 Minuti',
        'hourly' => 'Ogni Ora',
        'daily' => 'Ogni Giorno',
        'weekly' => 'Ogni Settimana',
        'monthly' => 'Ogni Mese',
        'quarterly' => 'Ogni Trimestre',
        'yearly' => 'Ogni Anno',
    ],
    'days' => [
        'sunday' => 'Domenica',
        'monday' => 'Lunedì',
        'tuesday' => 'Martedì',
        'wednesday' => 'Mercoledì',
        'thursday' => 'Giovedì',
        'friday' => 'Venerdì',
        'saturday' => 'Sabato',
    ],
    'cron' => [
        'help' => [
            'title' => 'Aiuto Espressioni Cron',
            'minute' => 'Minuto (0-59)',
            'hour' => 'Ora (0-23)',
            'day_of_month' => 'Giorno del Mese (1-31)',
            'month' => 'Mese (1-12)',
            'day_of_week' => 'Giorno della Settimana (0-6)',
            'examples' => [
                'every_minute' => '* * * * * - Ogni minuto',
                'every_hour' => '0 * * * * - Ogni ora',
                'every_day' => '0 0 * * * - Ogni giorno a mezzanotte',
                'every_monday' => '0 0 * * 1 - Ogni lunedì a mezzanotte',
            ],
        ],
    ],
    'model' => [
        'label' => 'schedule.model',
    ],
];
