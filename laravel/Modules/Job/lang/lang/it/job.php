<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Job',
    'plural_label' => 'Job',
    'group' => 'Sistema',
    'icon' => 'heroicon-o-cpu-chip',
    'sort' => 50,
    'badge' => 'Gestione processi in background',
  ),
  'model' => 
  array (
    'label' => 'Job',
    'plural' => 'Job',
    'description' => 'Processi in background e code di elaborazione',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco del job',
      'helper_text' => 'Identificativo numerico univoco del job nel sistema',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Coda',
      'placeholder' => 'Inserisci il nome della coda',
      'tooltip' => 'Nome della coda di elaborazione',
      'helper_text' => 'Coda specifica in cui il job è stato accodato per l\'elaborazione',
      'help' => 'Specifica la coda di priorità per l\'elaborazione',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'placeholder' => 'Dati del job',
      'tooltip' => 'Dati e parametri del job',
      'helper_text' => 'Informazioni e dati specifici necessari per l\'esecuzione del job',
      'help' => 'Contiene i dati serializzati necessari per l\'esecuzione',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Tentativi',
      'placeholder' => 'Numero di tentativi',
      'tooltip' => 'Numero di tentativi di esecuzione',
      'helper_text' => 'Numero di volte che il job è stato tentato di eseguire',
      'help' => 'Indica quante volte il job ha tentato l\'esecuzione',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Riservato alle',
      'tooltip' => 'Data di riserva del job',
      'helper_text' => 'Data e ora in cui il job è stato riservato per l\'esecuzione',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Disponibile alle',
      'placeholder' => 'Data di disponibilità',
      'tooltip' => 'Data di disponibilità per l\'esecuzione',
      'helper_text' => 'Data e ora in cui il job diventa disponibile per l\'esecuzione',
      'help' => 'Specifica quando il job può essere elaborato',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => 'Data di creazione del job',
      'helper_text' => 'Data e ora in cui il job è stato creato nel sistema',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => 'Data dell\'ultima modifica',
      'helper_text' => 'Data e ora dell\'ultimo aggiornamento del job',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Job',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary',
      'tooltip' => 'Crea un nuovo job',
      'modal' => 
      array (
        'heading' => 'Crea Nuovo Job',
        'description' => 'Inserisci i dettagli per il nuovo job',
        'confirm' => 'Crea Job',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Job creato con successo',
        'error' => 'Si è verificato un errore durante la creazione del job',
      ),
    ),
    'edit' => 
    array (
      'label' => 'Modifica Job',
      'icon' => 'heroicon-o-pencil',
      'color' => 'warning',
      'tooltip' => 'Modifica il job selezionato',
      'modal' => 
      array (
        'heading' => 'Modifica Job',
        'description' => 'Aggiorna le informazioni del job',
        'confirm' => 'Salva modifiche',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Job modificato con successo',
        'error' => 'Si è verificato un errore durante la modifica del job',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Elimina Job',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'tooltip' => 'Elimina il job selezionato',
      'modal' => 
      array (
        'heading' => 'Elimina Job',
        'description' => 'Sei sicuro di voler eliminare questo job? Questa azione è irreversibile.',
        'confirm' => 'Elimina',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Job eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'eliminazione del job',
      ),
      'confirmation' => 'Sei sicuro di voler eliminare questo job?',
    ),
    'retry' => 
    array (
      'label' => 'Riprova Job',
      'icon' => 'heroicon-o-arrow-path',
      'color' => 'info',
      'tooltip' => 'Riprova l\'esecuzione del job',
      'modal' => 
      array (
        'heading' => 'Riprova Job',
        'description' => 'Sei sicuro di voler riprovare l\'esecuzione di questo job?',
        'confirm' => 'Riprova',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Job rimesso in coda per la ri-esecuzione',
        'error' => 'Si è verificato un errore durante il rinvio del job',
      ),
    ),
    'view' => 
    array (
      'label' => 'Visualizza Job',
      'icon' => 'heroicon-o-eye',
      'color' => 'secondary',
      'tooltip' => 'Visualizza i dettagli del job',
    ),
    'bulk_actions' => 
    array (
      'delete' => 
      array (
        'label' => 'Elimina Selezionati',
        'icon' => 'heroicon-o-trash',
        'color' => 'danger',
        'tooltip' => 'Elimina tutti i job selezionati',
        'modal' => 
        array (
          'heading' => 'Elimina Job Selezionati',
          'description' => 'Sei sicuro di voler eliminare i job selezionati? Questa azione è irreversibile.',
          'confirm' => 'Elimina tutti',
          'cancel' => 'Annulla',
        ),
        'messages' => 
        array (
          'success' => 'Job eliminati con successo',
          'error' => 'Si è verificato un errore durante l\'eliminazione dei job',
        ),
      ),
      'retry' => 
      array (
        'label' => 'Riprova Selezionati',
        'icon' => 'heroicon-o-arrow-path',
        'color' => 'info',
        'tooltip' => 'Riprova l\'esecuzione dei job selezionati',
        'modal' => 
        array (
          'heading' => 'Riprova Job Selezionati',
          'description' => 'Sei sicuro di voler riprovare l\'esecuzione dei job selezionati?',
          'confirm' => 'Riprova tutti',
          'cancel' => 'Annulla',
        ),
        'messages' => 
        array (
          'success' => 'Job rimessi in coda per la ri-esecuzione',
          'error' => 'Si è verificato un errore durante il rinvio dei job',
        ),
      ),
    ),
  ),
  'sections' => 
  array (
    'basic_info' => 
    array (
      'label' => 'Informazioni Base',
      'description' => 'Informazioni fondamentali del job',
      'icon' => 'heroicon-o-information-circle',
    ),
    'execution' => 
    array (
      'label' => 'Esecuzione',
      'description' => 'Dettagli di esecuzione e scheduling',
      'icon' => 'heroicon-o-clock',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'description' => 'Dati e parametri del job',
      'icon' => 'heroicon-o-document-text',
    ),
  ),
  'filters' => 
  array (
    'queue' => 
    array (
      'label' => 'Coda',
      'placeholder' => 'Seleziona coda',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'options' => 
      array (
        'pending' => 'In attesa',
        'running' => 'In esecuzione',
        'failed' => 'Fallito',
        'completed' => 'Completato',
      ),
    ),
    'attempts' => 
    array (
      'label' => 'Tentativi',
      'placeholder' => 'Filtra per tentativi',
    ),
    'date_range' => 
    array (
      'label' => 'Periodo',
      'placeholder' => 'Seleziona il periodo',
    ),
  ),
  'messages' => 
  array (
    'empty_state' => 'Nessun job trovato',
    'search_placeholder' => 'Cerca job...',
    'loading' => 'Caricamento job in corso...',
    'total_count' => 'Totale job: :count',
    'created' => 'Job creato con successo',
    'updated' => 'Job aggiornato con successo',
    'deleted' => 'Job eliminato con successo',
    'retried' => 'Job rimesso in coda per la ri-esecuzione',
    'bulk_deleted' => 'Job eliminati con successo',
    'bulk_retried' => 'Job rimessi in coda per la ri-esecuzione',
    'error_general' => 'Si è verificato un errore. Riprova più tardi.',
    'error_validation' => 'Si sono verificati errori di validazione.',
    'error_permission' => 'Non hai i permessi per eseguire questa azione.',
    'success_operation' => 'Operazione completata con successo',
  ),
  'validation' => 
  array (
    'queue_required' => 'La coda è obbligatoria',
    'payload_required' => 'Il payload è obbligatorio',
    'attempts_numeric' => 'I tentativi devono essere numerici',
    'attempts_min' => 'I tentativi devono essere almeno :min',
    'available_at_required' => 'La data di disponibilità è obbligatoria',
    'available_at_after' => 'La data di disponibilità deve essere futura',
  ),
  'descriptions' => 
  array (
    'job_purpose' => 'Gestione dei processi in background e code di elaborazione',
    'queue_system' => 'Sistema di code per l\'elaborazione asincrona dei task',
    'retry_mechanism' => 'Meccanismo di ri-tentativo per job falliti',
    'monitoring' => 'Monitoraggio dello stato e delle performance dei job',
  ),
  'options' => 
  array (
    'queues' => 
    array (
      'default' => 'Default',
      'high' => 'Alta Priorità',
      'low' => 'Bassa Priorità',
      'emails' => 'Email',
      'notifications' => 'Notifiche',
      'reports' => 'Report',
    ),
    'statuses' => 
    array (
      'pending' => 'In attesa',
      'running' => 'In esecuzione',
      'failed' => 'Fallito',
      'completed' => 'Completato',
    ),
    'priorities' => 
    array (
      'high' => 'Alta',
      'normal' => 'Normale',
      'low' => 'Bassa',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
