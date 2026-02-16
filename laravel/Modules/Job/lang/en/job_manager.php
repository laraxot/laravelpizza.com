<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Job Management',
    'plural' => 'Job Management',
    'group' => 
    array (
      'name' => 'System',
      'description' => 'Centralized management of all jobs',
    ),
    'label' => 'Job Manager',
    'sort' => '1',
    'icon' => 'job-manager-animated',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo unico del Job Manager',
      'placeholder' => 'ID del Manager',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Name',
      'tooltip' => 'Name of the Job Manager',
      'placeholder' => 'Enter name',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Description',
      'tooltip' => 'Brief description of the job manager',
      'placeholder' => 'Job Manager description',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => 'Current status of the Job Manager',
      'placeholder' => 'Select status',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'tooltip' => 'Type of Job Manager',
      'placeholder' => 'Select type',
      'helper_text' => '',
      'description' => '',
    ),
    'priority' => 
    array (
      'label' => 'Priority',
      'tooltip' => 'Execution priority of the job manager',
      'placeholder' => 'Select priority',
      'helper_text' => '',
      'description' => '',
    ),
    'max_attempts' => 
    array (
      'label' => 'Max Attempts',
      'tooltip' => 'Maximum number of attempts to run the job manager',
      'placeholder' => 'Max attempts',
      'helper_text' => '',
      'description' => '',
    ),
    'timeout' => 
    array (
      'label' => 'Timeout',
      'tooltip' => 'Maximum execution time for the job manager',
      'placeholder' => 'Timeout',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'tooltip' => 'Creation date of the Job Manager',
      'placeholder' => 'Creation date',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Updated At',
      'tooltip' => 'Date of last update',
      'placeholder' => 'Update date',
      'helper_text' => '',
      'description' => '',
    ),
    'last_run' => 
    array (
      'label' => 'Last Run',
      'tooltip' => 'Date and time of last execution',
      'placeholder' => 'Last run',
      'helper_text' => '',
      'description' => '',
    ),
    'next_run' => 
    array (
      'label' => 'Next Run',
      'tooltip' => 'Date and time of next execution',
      'placeholder' => 'Next run',
      'helper_text' => '',
      'description' => '',
    ),
    'cron_expression' => 
    array (
      'label' => 'Cron Expression',
      'tooltip' => 'Cron expression for job scheduling',
      'placeholder' => 'Enter cron expression',
      'helper_text' => '',
      'description' => '',
    ),
    'output' => 
    array (
      'label' => 'Output',
      'tooltip' => 'Job execution output',
      'placeholder' => 'Output',
      'helper_text' => '',
      'description' => '',
    ),
    'error' => 
    array (
      'label' => 'Error',
      'tooltip' => 'Error message if the job fails',
      'placeholder' => 'Error',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Guard associated with the Job Manager',
      'placeholder' => 'Select Guard',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permissions',
      'tooltip' => 'Permissions associated with the Job Manager',
      'placeholder' => 'Select permissions',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome dell\'utente associato',
      'placeholder' => 'Inserisci nome',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome dell\'utente associato',
      'placeholder' => 'Inserisci cognome',
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
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'label' => 'Importa',
      'modal' => 
      array (
        'heading' => 'Importa Job Manager',
        'description' => 'Seleziona un file XLS o CSV da caricare per importare il Job Manager',
      ),
      'messages' => 
      array (
        'success' => 'Importazione del Job Manager avviata con successo',
      ),
      'icon' => 'upload',
      'color' => 'primary',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'modal' => 
      array (
        'heading' => 'Esporta Job Manager',
        'description' => 'Esporta i dati del Job Manager in un file',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager esportato con successo',
      ),
      'icon' => 'download',
      'color' => 'success',
    ),
    'run' => 
    array (
      'label' => 'Esegui',
      'modal' => 
      array (
        'heading' => 'Esegui Job Manager',
        'description' => 'Vuoi eseguire questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager avviato con successo',
      ),
      'icon' => 'play',
      'color' => 'primary',
    ),
    'pause' => 
    array (
      'label' => 'Pausa',
      'modal' => 
      array (
        'heading' => 'Metti in Pausa',
        'description' => 'Vuoi mettere in pausa questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager messo in pausa con successo',
      ),
      'icon' => 'pause',
      'color' => 'warning',
    ),
    'resume' => 
    array (
      'label' => 'Riprendi',
      'modal' => 
      array (
        'heading' => 'Riprendi Esecuzione',
        'description' => 'Vuoi riprendere l\'esecuzione di questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager ripreso con successo',
      ),
      'icon' => 'redo',
      'color' => 'success',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal' => 
      array (
        'heading' => 'Elimina Job Manager',
        'description' => 'Sei sicuro di voler eliminare questo Job Manager?',
      ),
      'messages' => 
      array (
        'success' => 'Job Manager eliminato con successo',
      ),
      'icon' => 'trash',
      'color' => 'danger',
    ),
  ),
  'messages' => 
  array (
    'no_jobs' => 'Nessun Job Manager presente',
    'manager_started' => 'Job Manager avviato',
    'manager_paused' => 'Job Manager in pausa',
    'manager_resumed' => 'Job Manager ripreso',
    'manager_completed' => 'Job Manager completato',
    'manager_failed' => 'Job Manager fallito',
  ),
  'statuses' => 
  array (
    'active' => 'Attivo',
    'paused' => 'In Pausa',
    'completed' => 'Completato',
    'failed' => 'Fallito',
  ),
  'types' => 
  array (
    'scheduler' => 'Schedulatore',
    'queue' => 'Coda',
    'worker' => 'Worker',
    'monitor' => 'Monitor',
  ),
  'priorities' => 
  array (
    'low' => 'Bassa',
    'normal' => 'Normale',
    'high' => 'Alta',
    'urgent' => 'Urgente',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
