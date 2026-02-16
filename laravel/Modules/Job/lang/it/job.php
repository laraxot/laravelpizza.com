<?php

declare(strict_types=1);

return array (
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Jobs',
      'subtitle' => 'Gestione dei processi in background',
      'description' => 'Visualizza e gestisci tutti i job del sistema',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Job',
      'subtitle' => 'Crea un nuovo job',
      'description' => 'Inserisci i dettagli per creare un nuovo job',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Job',
      'subtitle' => 'Modifica i dettagli del job',
      'description' => 'Aggiorna le informazioni del job selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Job',
      'subtitle' => 'Visualizza i dettagli completi del job',
      'description' => 'Informazioni dettagliate sul job selezionato',
    ),
  ),
  'widgets' => 
  array (
    'job_overview' => 
    array (
      'title' => 'Panoramica Jobs',
      'description' => 'Statistiche sui job del sistema',
    ),
    'recent_jobs' => 
    array (
      'title' => 'Jobs Recenti',
      'description' => 'Ultimi job eseguiti',
    ),
    'failed_jobs' => 
    array (
      'title' => 'Jobs Falliti',
      'description' => 'Jobs che hanno avuto errori',
    ),
  ),
  'navigation' => 
  array (
    'name' => 'Job',
    'plural' => 'Jobs',
    'group' => 
    array (
      'name' => 'Jobs',
      'description' => 'Gestione dei processi in background',
    ),
    'label' => 'Jobs',
    'sort' => 30,
    'icon' => 'heroicon-o-cpu-chip',
    'tooltip' => 'Gestisci i processi in background',
    'helper_text' => '',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'help' => 'Identificatore univoco del job',
      'tooltip' => 'ID del job',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Coda',
      'placeholder' => 'Seleziona la coda',
      'help' => 'La coda a cui appartiene il job',
      'tooltip' => 'Coda di elaborazione',
      'helper_text' => '',
      'options' => 
      array (
        'default' => 'Predefinita',
        'high' => 'Alta Priorità',
        'low' => 'Bassa Priorità',
        'emails' => 'Email',
        'notifications' => 'Notifiche',
      ),
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'placeholder' => 'Dati del job',
      'help' => 'Dati associati al job',
      'tooltip' => 'Contenuto del job',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Tentativi',
      'placeholder' => 'Numero di tentativi',
      'help' => 'Numero di tentativi per eseguire il job',
      'tooltip' => 'Tentativi di esecuzione',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Riservato il',
      'placeholder' => 'Data e ora riserva',
      'help' => 'Data e ora in cui il job è stato riservato',
      'tooltip' => 'Quando è stato riservato',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Disponibile il',
      'placeholder' => 'Data e ora disponibilità',
      'help' => 'Data e ora in cui il job è diventato disponibile',
      'tooltip' => 'Quando diventa disponibile',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'help' => 'Data di creazione del job',
      'tooltip' => 'Data creazione',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale del job',
      'tooltip' => 'Stato del job',
      'helper_text' => '',
      'options' => 
      array (
        'pending' => 'In Attesa',
        'processing' => 'In Elaborazione',
        'completed' => 'Completato',
        'failed' => 'Fallito',
        'cancelled' => 'Annullato',
        'retrying' => 'Riprova',
      ),
      'description' => '',
    ),
    'progress' => 
    array (
      'label' => 'Progresso',
      'placeholder' => 'Percentuale completamento',
      'help' => 'Percentuale di completamento del job',
      'tooltip' => 'Progresso del job',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo',
      'help' => 'Tipo di job (e.g., importazione, esportazione]',
      'tooltip' => 'Tipo di job',
      'helper_text' => '',
      'options' => 
      array (
        'import' => 'Importazione',
        'export' => 'Esportazione',
        'email' => 'Email',
        'notification' => 'Notifica',
        'report' => 'Report',
        'backup' => 'Backup',
        'cleanup' => 'Pulizia',
        'sync' => 'Sincronizzazione',
      ),
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del job',
      'help' => 'Nome del job',
      'tooltip' => 'Nome del job',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione',
      'help' => 'Descrizione del job',
      'tooltip' => 'Descrizione del job',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'placeholder' => 'Nome del guard',
      'help' => 'Guardiano del job',
      'tooltip' => 'Guard di autenticazione',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'placeholder' => 'Seleziona i permessi',
      'help' => 'Permessi associati al job',
      'tooltip' => 'Permessi del job',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'help' => 'Data dell\'ultimo aggiornamento del job',
      'tooltip' => 'Ultimo aggiornamento',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome del responsabile',
      'tooltip' => 'Nome responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome del responsabile',
      'tooltip' => 'Cognome responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
      'help' => 'Email del responsabile',
      'tooltip' => 'Email responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il telefono',
      'help' => 'Numero di telefono del responsabile',
      'tooltip' => 'Telefono responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci l\'indirizzo',
      'help' => 'Indirizzo del responsabile',
      'tooltip' => 'Indirizzo responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'help' => 'Città del responsabile',
      'tooltip' => 'Città responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'state' => 
    array (
      'label' => 'Stato/Provincia',
      'placeholder' => 'Inserisci lo stato',
      'help' => 'Stato o provincia del responsabile',
      'tooltip' => 'Stato responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'zip_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'help' => 'Codice postale del responsabile',
      'tooltip' => 'CAP responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Seleziona il paese',
      'help' => 'Paese del responsabile',
      'tooltip' => 'Paese responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'company' => 
    array (
      'label' => 'Azienda',
      'placeholder' => 'Inserisci l\'azienda',
      'help' => 'Azienda del responsabile',
      'tooltip' => 'Azienda responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'position' => 
    array (
      'label' => 'Posizione',
      'placeholder' => 'Inserisci la posizione',
      'help' => 'Posizione lavorativa del responsabile',
      'tooltip' => 'Posizione responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'website' => 
    array (
      'label' => 'Sito Web',
      'placeholder' => 'Inserisci l\'URL del sito',
      'help' => 'Sito web del responsabile',
      'tooltip' => 'Sito web responsabile',
      'helper_text' => '',
      'description' => '',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive',
      'help' => 'Note aggiuntive sul job',
      'tooltip' => 'Note del job',
      'helper_text' => '',
      'description' => '',
    ),
    'priority' => 
    array (
      'label' => 'Priorità',
      'placeholder' => 'Seleziona la priorità',
      'help' => 'Priorità di esecuzione del job',
      'tooltip' => 'Priorità del job',
      'helper_text' => '',
      'options' => 
      array (
        'low' => 'Bassa',
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
      ),
      'description' => '',
    ),
    'scheduled_at' => 
    array (
      'label' => 'Programmato per',
      'placeholder' => 'Data e ora programmazione',
      'help' => 'Data e ora di programmazione del job',
      'tooltip' => 'Quando è programmato',
      'helper_text' => '',
      'description' => '',
    ),
    'started_at' => 
    array (
      'label' => 'Iniziato il',
      'help' => 'Data e ora di inizio del job',
      'tooltip' => 'Quando è iniziato',
      'helper_text' => '',
      'description' => '',
    ),
    'finished_at' => 
    array (
      'label' => 'Completato il',
      'help' => 'Data e ora di completamento del job',
      'tooltip' => 'Quando è completato',
      'helper_text' => '',
      'description' => '',
    ),
    'error_message' => 
    array (
      'label' => 'Messaggio di Errore',
      'placeholder' => 'Dettagli dell\'errore',
      'help' => 'Messaggio di errore in caso di fallimento',
      'tooltip' => 'Errore del job',
      'helper_text' => '',
      'description' => '',
    ),
    'retry_count' => 
    array (
      'label' => 'Conteggio Riprova',
      'help' => 'Numero di tentativi di riprova',
      'tooltip' => 'Tentativi di riprova',
      'helper_text' => '',
      'description' => '',
    ),
    'max_retries' => 
    array (
      'label' => 'Max Riprova',
      'placeholder' => 'Numero massimo di riprove',
      'help' => 'Numero massimo di tentativi di riprova',
      'tooltip' => 'Massimo tentativi',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Job',
      'icon' => 'heroicon-o-plus',
      'tooltip' => 'Crea un nuovo job',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Job',
      'icon' => 'heroicon-o-pencil',
      'tooltip' => 'Modifica il job',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Job',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina il job',
    ),
    'view' => 
    array (
      'label' => 'Visualizza Job',
      'icon' => 'heroicon-o-eye',
      'tooltip' => 'Visualizza i dettagli del job',
    ),
    'retry' => 
    array (
      'label' => 'Riprova',
      'icon' => 'heroicon-o-arrow-path',
      'tooltip' => 'Riprova l\'esecuzione del job',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Annulla il job',
    ),
    'pause' => 
    array (
      'label' => 'Pausa',
      'icon' => 'heroicon-o-pause',
      'tooltip' => 'Metti in pausa il job',
    ),
    'resume' => 
    array (
      'label' => 'Riprendi',
      'icon' => 'heroicon-o-play',
      'tooltip' => 'Riprendi l\'esecuzione del job',
    ),
    'clear_failed' => 
    array (
      'label' => 'Pulisci Falliti',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina tutti i job falliti',
    ),
    'retry_failed' => 
    array (
      'label' => 'Riprova Falliti',
      'icon' => 'heroicon-o-arrow-path',
      'tooltip' => 'Riprova tutti i job falliti',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Job creato con successo',
    'updated' => 'Job aggiornato con successo',
    'deleted' => 'Job eliminato con successo',
    'retried' => 'Job riprovato con successo',
    'cancelled' => 'Job annullato con successo',
    'paused' => 'Job messo in pausa',
    'resumed' => 'Job ripreso con successo',
    'cleared_failed' => 'Job falliti eliminati con successo',
    'retried_failed' => 'Job falliti riprovati con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'not_found' => 'Job non trovato',
    'already_running' => 'Il job è già in esecuzione',
    'cannot_cancel' => 'Impossibile annullare il job',
    'cannot_pause' => 'Impossibile mettere in pausa il job',
  ),
  'statuses' => 
  array (
    'pending' => 'In Attesa',
    'processing' => 'In Elaborazione',
    'completed' => 'Completato',
    'failed' => 'Fallito',
    'cancelled' => 'Annullato',
    'retrying' => 'Riprova',
    'paused' => 'In Pausa',
  ),
  'types' => 
  array (
    'import' => 'Importazione',
    'export' => 'Esportazione',
    'email' => 'Email',
    'notification' => 'Notifica',
    'report' => 'Report',
    'backup' => 'Backup',
    'cleanup' => 'Pulizia',
    'sync' => 'Sincronizzazione',
    'maintenance' => 'Manutenzione',
    'analysis' => 'Analisi',
  ),
  'priorities' => 
  array (
    'low' => 'Bassa',
    'normal' => 'Normale',
    'high' => 'Alta',
    'urgent' => 'Urgente',
  ),
  'filters' => 
  array (
    'status' => 
    array (
      'label' => 'Per Stato',
      'tooltip' => 'Filtra per stato del job',
    ),
    'type' => 
    array (
      'label' => 'Per Tipo',
      'tooltip' => 'Filtra per tipo di job',
    ),
    'priority' => 
    array (
      'label' => 'Per Priorità',
      'tooltip' => 'Filtra per priorità',
    ),
    'queue' => 
    array (
      'label' => 'Per Coda',
      'tooltip' => 'Filtra per coda',
    ),
    'date_range' => 
    array (
      'label' => 'Intervallo Date',
      'start_date' => 'Data Inizio',
      'end_date' => 'Data Fine',
      'tooltip' => 'Filtra per intervallo di date',
    ),
    'failed_only' => 
    array (
      'label' => 'Solo Falliti',
      'tooltip' => 'Mostra solo job falliti',
    ),
  ),
  'bulk_actions' => 
  array (
    'retry_selected' => 
    array (
      'label' => 'Riprova Selezionati',
      'icon' => 'heroicon-o-arrow-path',
    ),
    'cancel_selected' => 
    array (
      'label' => 'Annulla Selezionati',
      'icon' => 'heroicon-o-x-circle',
    ),
    'delete_selected' => 
    array (
      'label' => 'Elimina Selezionati',
      'icon' => 'heroicon-o-trash',
    ),
    'pause_selected' => 
    array (
      'label' => 'Pausa Selezionati',
      'icon' => 'heroicon-o-pause',
    ),
    'resume_selected' => 
    array (
      'label' => 'Riprendi Selezionati',
      'icon' => 'heroicon-o-play',
    ),
  ),
  'notifications' => 
  array (
    'job_started' => 'Job iniziato',
    'job_completed' => 'Job completato',
    'job_failed' => 'Job fallito',
    'job_cancelled' => 'Job annullato',
    'job_retried' => 'Job riprovato',
  ),
  'validation' => 
  array (
    'name' => 
    array (
      'required' => 'Il nome del job è obbligatorio',
      'max' => 'Il nome non può superare :max caratteri',
    ),
    'type' => 
    array (
      'required' => 'Il tipo è obbligatorio',
      'in' => 'Tipo di job non valido',
    ),
    'priority' => 
    array (
      'required' => 'La priorità è obbligatoria',
      'in' => 'Priorità non valida',
    ),
    'scheduled_at' => 
    array (
      'date' => 'La data di programmazione deve essere una data valida',
      'after' => 'La data di programmazione deve essere nel futuro',
    ),
    'max_retries' => 
    array (
      'integer' => 'Il numero massimo di riprove deve essere un numero intero',
      'min' => 'Il numero massimo di riprove deve essere almeno :min',
    ),
  ),
  'model' => 
  array (
    'label' => 'Job',
    'plural' => 'Jobs',
    'description' => 'Gestione dei processi in background',
  ),
  'search_placeholder' => 'Cerca per nome, tipo o stato...',
  'label' => 'Job',
  'plural_label' => 'Job (Plurale)',
);
