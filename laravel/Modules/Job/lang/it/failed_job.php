<?php

declare(strict_types=1);

return array (
  'pages' => 'Pagine',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Jobs Falliti',
    'plural' => 'Jobs Falliti',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione e recupero dei jobs falliti',
    ),
    'label' => 'Jobs Falliti',
    'sort' => 93,
    'icon' => 'job-failed-job',
  ),
  'model' => 
  array (
    'label' => 'Job Fallito',
    'plural' => 
    array (
      'label' => 'Jobs Falliti',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'uuid' => 
    array (
      'label' => 'UUID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'connection' => 
    array (
      'label' => 'Connessione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Coda',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'exception' => 
    array (
      'label' => 'Eccezione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_at' => 
    array (
      'label' => 'Fallito il',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Tentativi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'max_attempts' => 
    array (
      'label' => 'Tentativi Massimi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'tooltip' => '',
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
  ),
  'actions' => 
  array (
    'retry' => 
    array (
      'label' => 'Riprova',
      'modal' => 
      array (
        'heading' => 'Riprova Job',
        'description' => 'Vuoi riprovare ad eseguire questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Job riavviato con successo',
      ),
    ),
    'retry_all' => 
    array (
      'label' => 'Riprova Tutti',
      'modal' => 
      array (
        'heading' => 'Riprova Tutti i Jobs',
        'description' => 'Vuoi riprovare tutti i jobs falliti?',
      ),
      'messages' => 
      array (
        'success' => 'Jobs riavviati con successo',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal' => 
      array (
        'heading' => 'Elimina Job',
        'description' => 'Sei sicuro di voler eliminare questo job fallito?',
      ),
      'messages' => 
      array (
        'success' => 'Job eliminato con successo',
      ),
    ),
    'delete_all' => 
    array (
      'label' => 'Elimina Tutti',
      'modal' => 
      array (
        'heading' => 'Elimina Tutti i Jobs',
        'description' => 'Sei sicuro di voler eliminare tutti i jobs falliti?',
      ),
      'messages' => 
      array (
        'success' => 'Jobs eliminati con successo',
      ),
    ),
    'clear' => 
    array (
      'label' => 'Pulisci Tutto',
      'modal' => 
      array (
        'heading' => 'Pulisci Jobs Falliti',
        'description' => 'Sei sicuro di voler eliminare tutti i jobs falliti?',
      ),
      'messages' => 
      array (
        'success' => 'Jobs falliti eliminati con successo',
      ),
    ),
    'logout' => 
    array (
      'tooltip' => 'logout',
      'icon' => 'logout',
      'label' => 'logout',
    ),
    'reorderRecords' => 
    array (
      'tooltip' => 'reorderRecords',
      'icon' => 'reorderRecords',
      'label' => 'reorderRecords',
    ),
    'cancel' => 
    array (
      'tooltip' => 'cancel',
      'icon' => 'cancel',
      'label' => 'cancel',
    ),
    'openColumnManager' => 
    array (
      'tooltip' => 'openColumnManager',
      'icon' => 'openColumnManager',
      'label' => 'openColumnManager',
    ),
    'submit' => 
    array (
      'tooltip' => 'submit',
      'icon' => 'submit',
    ),
  ),
  'messages' => 
  array (
    'no_failed_jobs' => 'Nessun job fallito',
    'retry_success' => 'Job riavviato con successo',
    'retry_all_success' => 'Tutti i jobs sono stati riavviati con successo',
    'delete_success' => 'Job eliminato con successo',
    'delete_all_success' => 'Tutti i jobs sono stati eliminati con successo',
    'clear_success' => 'Jobs falliti eliminati con successo',
    'max_attempts_exceeded' => 'Il job ha superato il numero massimo di tentativi',
    'job_not_found' => 'Job non trovato',
    'invalid_payload' => 'Payload non valido',
  ),
  'statuses' => 
  array (
    'pending' => 'In Attesa',
    'processing' => 'In Elaborazione',
    'failed' => 'Fallito',
    'completed' => 'Completato',
    'cancelled' => 'Annullato',
    'max_attempts' => 'Tentativi Massimi Superati',
  ),
  'error_types' => 
  array (
    'max_attempts' => 'Tentativi Massimi Superati',
    'timeout' => 'Timeout',
    'memory_limit' => 'Limite Memoria Superato',
    'connection' => 'Errore di Connessione',
    'queue' => 'Errore di Coda',
    'payload' => 'Errore nel Payload',
    'system' => 'Errore di Sistema',
  ),
  'plural' => 
  array (
    'model' => 
    array (
      'label' => 'failed job.plural.model',
    ),
    'label' => 'Jobs Falliti',
    'sort' => 93,
    'icon' => 'job-failed-job',
  ),
  'label' => 'failed job',
  'plural_label' => 'Failed Job (Plurale)',
);
