<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Jobs in Attesa',
    'plural' => 'Jobs in Attesa',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Monitoraggio dei jobs in coda',
    ),
    'label' => 'Jobs in Attesa',
    'sort' => '15',
    'icon' => 'heroicon-o-cog',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco del job',
      'placeholder' => 'ID del job',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Coda',
      'tooltip' => 'Nome della coda del job',
      'placeholder' => 'Seleziona la coda',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'tooltip' => 'Dati associati al job',
      'placeholder' => 'Carica i dati del job',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Tentativi',
      'tooltip' => 'Numero di tentativi di esecuzione',
      'placeholder' => 'Tentativi eseguiti',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Riservato il',
      'tooltip' => 'Data e ora in cui il job è stato riservato',
      'placeholder' => 'Seleziona la data',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Disponibile il',
      'tooltip' => 'Data e ora di disponibilità del job',
      'placeholder' => 'Seleziona la data',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => 'Data di creazione del job',
      'placeholder' => 'Data di creazione',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Stato attuale del job',
      'placeholder' => 'Seleziona stato',
      'helper_text' => '',
      'description' => '',
    ),
    'priority' => 
    array (
      'label' => 'Priorità',
      'tooltip' => 'Priorità del job',
      'placeholder' => 'Seleziona priorità',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Tipo di job (Importazione, Esportazione, etc.)',
      'placeholder' => 'Seleziona tipo',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del job',
      'placeholder' => 'Inserisci il nome del job',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Descrizione del job',
      'placeholder' => 'Inserisci la descrizione',
      'helper_text' => '',
      'description' => '',
    ),
    'delay' => 
    array (
      'label' => 'Ritardo',
      'tooltip' => 'Tempo di ritardo prima che il job venga eseguito',
      'placeholder' => 'Inserisci il ritardo',
      'helper_text' => '',
      'description' => '',
    ),
    'timeout' => 
    array (
      'label' => 'Timeout',
      'tooltip' => 'Tempo massimo di esecuzione del job',
      'placeholder' => 'Inserisci il timeout',
      'helper_text' => '',
      'description' => '',
    ),
    'tags' => 
    array (
      'label' => 'Tags',
      'tooltip' => 'Etichette associate al job',
      'placeholder' => 'Inserisci i tags',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome dell\'utente',
      'placeholder' => 'Inserisci il nome',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome dell\'utente',
      'placeholder' => 'Inserisci il cognome',
      'helper_text' => '',
      'description' => '',
    ),
    'select_all' => 
    array (
      'label' => 'Seleziona Tutti',
      'tooltip' => 'Seleziona tutti gli elementi disponibili',
      'placeholder' => '',
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
      'tooltip' => 'Importa dati da un file XLS o CSV',
      'icon' => 'import-icon',
      'color' => 'blue',
      'fields' => 
      array (
        'import_file' => 
        array (
          'label' => 'Seleziona un file XLS o CSV da caricare',
          'tooltip' => 'Seleziona un file da caricare per l\'importazione',
          'placeholder' => 'Scegli un file',
        ),
      ),
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta i dati in un file',
      'icon' => 'export-icon',
      'color' => 'green',
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 
        array (
          'label' => 'Nome area',
          'tooltip' => 'Nome dell\'area da esportare',
        ),
        'parent_name' => 
        array (
          'label' => 'Nome area livello superiore',
          'tooltip' => 'Nome dell\'area di livello superiore',
        ),
      ),
    ),
    'process' => 
    array (
      'label' => 'Processa',
      'tooltip' => 'Processa il job in attesa',
      'icon' => 'play-circle',
      'color' => 'green',
      'modal' => 
      array (
        'heading' => 'Processa Job',
        'description' => 'Vuoi processare questo job in attesa?',
      ),
      'messages' => 
      array (
        'success' => 'Job processato con successo',
      ),
    ),
    'cancel' => 
    array (
      'label' => 'Cancella',
      'tooltip' => 'Cancella il job in attesa',
      'icon' => 'delete-icon',
      'color' => 'red',
      'modal' => 
      array (
        'heading' => 'Cancella Job',
        'description' => 'Vuoi cancellare questo job in attesa?',
      ),
      'messages' => 
      array (
        'success' => 'Job cancellato con successo',
      ),
    ),
    'retry' => 
    array (
      'label' => 'Riprova',
      'tooltip' => 'Riprova il job fallito',
      'icon' => 'redo',
      'color' => 'yellow',
      'modal' => 
      array (
        'heading' => 'Riprova Job',
        'description' => 'Vuoi riprovare questo job?',
      ),
      'messages' => 
      array (
        'success' => 'Job riprovato con successo',
      ),
    ),
  ),
  'messages' => 
  array (
    'no_jobs' => 'Nessun job in attesa',
    'job_processed' => 'Job processato',
    'job_cancelled' => 'Job cancellato',
    'job_retried' => 'Job riprovato',
  ),
  'statuses' => 
  array (
    'waiting' => 'In Attesa',
    'reserved' => 'Riservato',
    'delayed' => 'Ritardato',
    'ready' => 'Pronto',
  ),
  'priorities' => 
  array (
    'low' => 'Bassa',
    'normal' => 'Normale',
    'high' => 'Alta',
    'urgent' => 'Urgente',
  ),
  'types' => 
  array (
    'default' => 'Default',
    'scheduled' => 'Schedulato',
    'recurring' => 'Ricorrente',
    'batch' => 'Batch',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
