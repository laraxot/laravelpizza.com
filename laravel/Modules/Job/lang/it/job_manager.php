<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Gestione Jobs',
    'plural' => 'Gestione Jobs',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione centralizzata di tutti i jobs',
    ),
    'label' => 'Job Manager',
    'sort' => 1,
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
      'label' => 'Nome',
      'tooltip' => 'Nome del Job Manager',
      'placeholder' => 'Inserisci nome',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Breve descrizione del job manager',
      'placeholder' => 'Descrizione del Job Manager',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Stato corrente del Job Manager',
      'placeholder' => 'Seleziona stato',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Tipo di Job Manager',
      'placeholder' => 'Seleziona tipo',
      'helper_text' => '',
      'description' => '',
    ),
    'priority' => 
    array (
      'label' => 'Priorità',
      'tooltip' => 'Priorità di esecuzione del job manager',
      'placeholder' => 'Seleziona priorità',
      'helper_text' => '',
      'description' => '',
    ),
    'max_attempts' => 
    array (
      'label' => 'Tentativi Massimi',
      'tooltip' => 'Numero massimo di tentativi per eseguire il job manager',
      'placeholder' => 'Tentativi massimi',
      'helper_text' => '',
      'description' => '',
    ),
    'timeout' => 
    array (
      'label' => 'Timeout',
      'tooltip' => 'Tempo massimo per l\'esecuzione del job manager',
      'placeholder' => 'Timeout',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => 'Data di creazione del Job Manager',
      'placeholder' => 'Data di creazione',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'tooltip' => 'Data dell\'ultimo aggiornamento',
      'placeholder' => 'Data aggiornamento',
      'helper_text' => '',
      'description' => '',
    ),
    'last_run' => 
    array (
      'label' => 'Ultima Esecuzione',
      'tooltip' => 'Data e ora dell\'ultima esecuzione',
      'placeholder' => 'Ultima esecuzione',
      'helper_text' => '',
      'description' => '',
    ),
    'next_run' => 
    array (
      'label' => 'Prossima Esecuzione',
      'tooltip' => 'Data e ora della prossima esecuzione',
      'placeholder' => 'Prossima esecuzione',
      'helper_text' => '',
      'description' => '',
    ),
    'cron_expression' => 
    array (
      'label' => 'Espressione Cron',
      'tooltip' => 'Espressione cron per la pianificazione del job',
      'placeholder' => 'Inserisci espressione cron',
      'helper_text' => '',
      'description' => '',
    ),
    'output' => 
    array (
      'label' => 'Output',
      'tooltip' => 'Output dell\'esecuzione del job',
      'placeholder' => 'Output',
      'helper_text' => '',
      'description' => '',
    ),
    'error' => 
    array (
      'label' => 'Errore',
      'tooltip' => 'Messaggio di errore se il job fallisce',
      'placeholder' => 'Errore',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => 'Guard a cui è associato il Job Manager',
      'placeholder' => 'Seleziona Guard',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => 'Permessi associati al Job Manager',
      'placeholder' => 'Seleziona permessi',
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
    'openFilters' => 
    array (
      'label' => 'openFilters',
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
  'label' => 'Job Manager',
  'plural_label' => 'Job Manager (Plurale)',
);
