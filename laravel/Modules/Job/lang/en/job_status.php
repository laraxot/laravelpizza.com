<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Stato Jobs',
    'plural' => 'Stati Jobs',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Monitoraggio dello stato dei jobs',
    ),
    'label' => 'Stato Jobs',
    'sort' => '73',
    'icon' => 'job-status-animated',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del job monitorato',
      'placeholder' => 'Inserisci nome del job',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Guard associato al job',
      'placeholder' => 'Seleziona guard',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Permessi associati al job',
      'placeholder' => 'Seleziona permessi',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'tooltip' => 'Data dell\'ultimo aggiornamento dello stato del job',
      'placeholder' => 'Data di aggiornamento',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome dell\'utente che ha creato o gestisce il job',
      'placeholder' => 'Nome responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome dell\'utente che ha creato o gestisce il job',
      'placeholder' => 'Cognome responsabile',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'start' => 
    array (
      'label' => 'Avvia',
      'modal' => 
      array (
        'heading' => 'Avvia Job Status',
        'description' => 'Vuoi avviare il monitoraggio per questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Monitoraggio avviato con successo',
      ),
      'icon' => 'play',
      'color' => 'primary',
    ),
    'pause' => 
    array (
      'label' => 'Pausa',
      'modal' => 
      array (
        'heading' => 'Pausa Job Status',
        'description' => 'Vuoi mettere in pausa il monitoraggio di questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Monitoraggio messo in pausa con successo',
      ),
      'icon' => 'pause',
      'color' => 'warning',
    ),
    'resume' => 
    array (
      'label' => 'Riprendi',
      'modal' => 
      array (
        'heading' => 'Riprendi Job Status',
        'description' => 'Vuoi riprendere il monitoraggio di questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Monitoraggio ripreso con successo',
      ),
      'icon' => 'redo',
      'color' => 'success',
    ),
    'stop' => 
    array (
      'label' => 'Ferma',
      'modal' => 
      array (
        'heading' => 'Ferma Job Status',
        'description' => 'Sei sicuro di voler fermare il monitoraggio di questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Monitoraggio fermato con successo',
      ),
      'icon' => 'stop',
      'color' => 'danger',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'modal' => 
      array (
        'heading' => 'Esporta Dati Job Status',
        'description' => 'Seleziona il formato per esportare i dati del job',
      ),
      'messages' => 
      array (
        'success' => 'Dati esportati con successo',
      ),
      'icon' => 'download',
      'color' => 'info',
    ),
    'label' => 'Stato Jobs',
    'sort' => '73',
    'icon' => 'job-status-animated',
  ),
  'messages' => 
  array (
    'no_jobs' => 'Nessun job monitorato al momento',
    'job_started' => 'Monitoraggio del job avviato',
    'job_paused' => 'Monitoraggio del job messo in pausa',
    'job_resumed' => 'Monitoraggio del job ripreso',
    'job_stopped' => 'Monitoraggio del job fermato',
    'job_exported' => 'Dati esportati correttamente',
  ),
  'title' => 'job status',
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
