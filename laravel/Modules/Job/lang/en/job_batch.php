<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Job Batch',
    'plural' => 'Job Batches',
    'group' => 
    array (
      'name' => 'Jobs',
      'description' => 'Gestione dei processi in background',
    ),
    'label' => 'Job Batch',
    'sort' => '10',
    'icon' => 'job-batch-animated',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo unico del job batch',
      'placeholder' => 'ID del Batch',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del batch di job',
      'placeholder' => 'Inserisci nome batch',
      'helper_text' => '',
      'description' => '',
    ),
    'total_jobs' => 
    array (
      'label' => 'Jobs Totali',
      'tooltip' => 'Numero totale di jobs nel batch',
      'placeholder' => 'Numero di jobs totali',
      'helper_text' => '',
      'description' => '',
    ),
    'pending_jobs' => 
    array (
      'label' => 'Jobs in Attesa',
      'tooltip' => 'Numero di jobs ancora in attesa di elaborazione',
      'placeholder' => 'Jobs in attesa',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_jobs' => 
    array (
      'label' => 'Jobs Falliti',
      'tooltip' => 'Numero di jobs che hanno fallito',
      'placeholder' => 'Jobs falliti',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_job_ids' => 
    array (
      'label' => 'ID Jobs Falliti',
      'tooltip' => 'Identificativo dei jobs che hanno fallito',
      'placeholder' => 'ID dei jobs falliti',
      'helper_text' => '',
      'description' => '',
    ),
    'options' => 
    array (
      'label' => 'Opzioni',
      'tooltip' => 'Opzioni di configurazione per il job batch',
      'placeholder' => 'Seleziona opzioni',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => 'Data di creazione del job batch',
      'placeholder' => 'Data creazione',
      'helper_text' => '',
      'description' => '',
    ),
    'cancelled_at' => 
    array (
      'label' => 'Cancellato il',
      'tooltip' => 'Data di cancellazione del batch',
      'placeholder' => 'Data cancellazione',
      'helper_text' => '',
      'description' => '',
    ),
    'finished_at' => 
    array (
      'label' => 'Terminato il',
      'tooltip' => 'Data di terminazione del batch',
      'placeholder' => 'Data di terminazione',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Guard a cui è associato il job batch',
      'placeholder' => 'Seleziona guard',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Permessi associati al job batch',
      'placeholder' => 'Seleziona permessi',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'tooltip' => 'Data dell\'ultimo aggiornamento del batch',
      'placeholder' => 'Data aggiornamento',
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
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'label' => 'Importa',
      'modal' => 
      array (
        'heading' => 'Importa Job Batch',
        'description' => 'Seleziona un file XLS o CSV da caricare per importare il job batch',
      ),
      'messages' => 
      array (
        'success' => 'Importazione del job batch avviata con successo',
      ),
      'icon' => 'upload',
      'color' => 'primary',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'modal' => 
      array (
        'heading' => 'Esporta Job Batch',
        'description' => 'Esporta i dati del job batch in un file',
      ),
      'messages' => 
      array (
        'success' => 'Job batch esportato con successo',
      ),
      'icon' => 'download',
      'color' => 'success',
    ),
    'retry' => 
    array (
      'label' => 'Riprova',
      'modal' => 
      array (
        'heading' => 'Riprova Jobs Falliti',
        'description' => 'Vuoi riprovare a eseguire i jobs che sono falliti?',
      ),
      'messages' => 
      array (
        'success' => 'Jobs riavviati con successo',
      ),
      'icon' => 'redo',
      'color' => 'warning',
    ),
    'cancel' => 
    array (
      'label' => 'Cancella',
      'modal' => 
      array (
        'heading' => 'Cancella Batch',
        'description' => 'Sei sicuro di voler cancellare questo job batch?',
      ),
      'messages' => 
      array (
        'success' => 'Job batch cancellato con successo',
      ),
      'icon' => 'trash',
      'color' => 'danger',
    ),
  ),
  'messages' => 
  array (
    'no_failed_jobs' => 'Nessun job fallito',
    'batch_cancelled' => 'Job batch cancellato',
    'batch_finished' => 'Job batch completato',
    'batch_processing' => 'Job batch in elaborazione',
  ),
  'statuses' => 
  array (
    'pending' => 'In Attesa',
    'processing' => 'In Elaborazione',
    'completed' => 'Completato',
    'failed' => 'Fallito',
    'partial' => 'Completato Parzialmente',
  ),
  'types' => 
  array (
    'csv' => 'CSV',
    'excel' => 'Excel',
    'json' => 'JSON',
    'xml' => 'XML',
  ),
  'model' => 
  array (
    'label' => 'job batch.model',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
