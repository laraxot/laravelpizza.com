<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Schedulatore',
    'plural' => 'Schedulatori',
    'group' => 
    array (
      'name' => 'Jobs',
      'description' => 'Gestione dei job schedulati',
    ),
    'label' => 'Schedulatore',
    'sort' => '55',
    'icon' => 'job-schedule-animated',
  ),
  'resource' => 
  array (
    'single' => 'Schedule',
    'plural' => 'Schedules',
    'navigation' => 'Settings',
    'history' => 'Show run history',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Inserisci il nome del job programmato',
      'placeholder' => 'Nome del job',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Seleziona il guardiano per il job',
      'placeholder' => 'Nome del guardiano',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Assegna i permessi necessari al job',
      'placeholder' => 'Permessi',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del responsabile',
      'placeholder' => 'Nome responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome del responsabile',
      'placeholder' => 'Cognome responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'command' => 
    array (
      'label' => 'Command',
      'tooltip' => 'Inserisci il comando da eseguire',
      'placeholder' => 'Comando',
      'helper_text' => '',
      'description' => '',
    ),
    'arguments' => 
    array (
      'label' => 'Arguments',
      'tooltip' => 'Specificare eventuali argomenti per il comando',
      'placeholder' => 'Argomenti',
      'helper_text' => '',
      'description' => '',
    ),
    'options' => 
    array (
      'label' => 'Options',
      'tooltip' => 'Inserisci eventuali opzioni per il comando',
      'placeholder' => 'Opzioni',
      'helper_text' => '',
      'description' => '',
    ),
    'expression' => 
    array (
      'label' => 'Cron Expression',
      'tooltip' => 'Imposta l\'espressione cron per la pianificazione',
      'placeholder' => 'Espressione Cron',
      'helper_text' => '',
      'description' => '',
    ),
    'log_filename' => 
    array (
      'label' => 'Log Filename',
      'tooltip' => 'Nome del file di log',
      'placeholder' => 'Log filename',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => 'Stato corrente del job',
      'placeholder' => 'Stato',
      'helper_text' => '',
      'description' => '',
    ),
    'actions' => 
    array (
      'label' => 'Actions',
      'tooltip' => 'Azioni disponibili per il job',
      'icon' => 'action-icon',
      'color' => 'blue',
      'helper_text' => '',
      'description' => '',
    ),
    'run_in_background' => 
    array (
      'label' => 'Run in Background',
      'tooltip' => 'Esegui il job in background',
      'placeholder' => 'Run in background',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'tooltip' => 'Data di creazione del job',
      'placeholder' => 'Data creazione',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Updated At',
      'tooltip' => 'Ultima data di aggiornamento',
      'placeholder' => 'Data aggiornamento',
      'helper_text' => '',
      'description' => '',
    ),
    'timezone' => 
    array (
      'label' => 'Fuso Orario',
      'tooltip' => 'Imposta il fuso orario per il job',
      'placeholder' => 'Fuso orario',
      'helper_text' => '',
      'description' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'messages' => 
  array (
    'no-records-found' => 'No records found.',
    'save-success' => 'Data saved successfully.',
    'save-error' => 'Error saving data.',
    'timezone' => 'All schedules will be executed in the timezone: ',
    'select' => 'Select a command',
    'custom' => 'Custom Command',
    'custom-command-here' => 'Custom Command here (e.g. `cat /proc/cpuinfo` or `artisan db:migrate`)',
  ),
  'status' => 
  array (
    'active' => 'Active',
    'inactive' => 'Inactive',
    'trashed' => 'Trashed',
    'running' => 'In Esecuzione',
    'failed' => 'Fallito',
  ),
  'buttons' => 
  array (
    'inactivate' => 
    array (
      'label' => 'Inactivate',
      'icon' => 'icon-inactivate',
      'color' => 'gray',
    ),
    'activate' => 
    array (
      'label' => 'Activate',
      'icon' => 'icon-activate',
      'color' => 'green',
    ),
    'history' => 
    array (
      'label' => 'History',
      'icon' => 'icon-history',
      'color' => 'purple',
    ),
    'run' => 
    array (
      'label' => 'Esegui Ora',
      'modal' => 
      array (
        'heading' => 'Esegui Schedule',
        'description' => 'Vuoi eseguire questo schedule ora?',
      ),
      'messages' => 
      array (
        'success' => 'Schedule eseguito con successo',
      ),
      'icon' => 'icon-run',
      'color' => 'blue',
    ),
    'toggle' => 
    array (
      'label' => 'Attiva/Disattiva',
      'modal' => 
      array (
        'heading' => 'Modifica Stato',
        'description' => 'Vuoi modificare lo stato di questo schedule?',
      ),
      'messages' => 
      array (
        'success' => 'Stato modificato con successo',
      ),
      'icon' => 'icon-toggle',
      'color' => 'orange',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal' => 
      array (
        'heading' => 'Elimina Schedule',
        'description' => 'Sei sicuro di voler eliminare questo schedule?',
      ),
      'messages' => 
      array (
        'success' => 'Schedule eliminato con successo',
      ),
      'icon' => 'icon-delete',
      'color' => 'red',
    ),
  ),
  'validation' => 
  array (
    'cron' => 'The field must be filled in the cron expression format.',
    'regex' => 'The :attribute field must only contain letters, numbers, dashes, and underscores. Comma is also allowed.',
  ),
  'frequencies' => 
  array (
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
  ),
  'days' => 
  array (
    'sunday' => 'Domenica',
    'monday' => 'Lunedì',
    'tuesday' => 'Martedì',
    'wednesday' => 'Mercoledì',
    'thursday' => 'Giovedì',
    'friday' => 'Venerdì',
    'saturday' => 'Sabato',
  ),
  'cron' => 
  array (
    'help' => 
    array (
      'title' => 'Aiuto Espressioni Cron',
      'minute' => 'Minuto (0-59)',
      'hour' => 'Ora (0-23)',
      'day_of_month' => 'Giorno del Mese (1-31)',
      'month' => 'Mese (1-12)',
      'day_of_week' => 'Giorno della Settimana (0-6)',
      'examples' => 
      array (
        'every_minute' => '* * * * * - Ogni minuto',
        'every_hour' => '0 * * * * - Ogni ora',
        'every_day' => '0 0 * * * - Ogni giorno a mezzanotte',
        'every_monday' => '0 0 * * 1 - Ogni lunedì a mezzanotte',
      ),
    ),
  ),
  'model' => 
  array (
    'label' => 'schedule.model',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'actions' => 
  array (
  ),
);
