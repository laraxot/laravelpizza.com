<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Stato Sistema',
    'plural' => 'Stato Sistema',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Monitoraggio e diagnostica del sistema',
    ),
    'label' => 'health',
    'sort' => '14',
    'icon' => 'xot-health',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del controllo',
      'help' => 'Nome identificativo del controllo di sistema',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'help' => 'Stato attuale del controllo',
      'options' => 
      array (
        'ok' => 'Funzionante',
        'warning' => 'Attenzione',
        'error' => 'Errore',
        'critical' => 'Critico',
        'unknown' => 'Sconosciuto',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_check' => 
    array (
      'label' => 'Ultimo Controllo',
      'help' => 'Data e ora dell\'ultimo controllo effettuato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'next_check' => 
    array (
      'label' => 'Prossimo Controllo',
      'help' => 'Data e ora del prossimo controllo programmato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'details' => 
    array (
      'label' => 'Dettagli',
      'help' => 'Informazioni dettagliate sullo stato del controllo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'help' => 'Categoria del controllo di sistema',
      'options' => 
      array (
        'database' => 'Database',
        'cache' => 'Cache',
        'storage' => 'Storage',
        'queue' => 'Code',
        'services' => 'Servizi',
        'security' => 'Sicurezza',
        'performance' => 'Performance',
        'backup' => 'Backup',
        'logs' => 'Log',
        'network' => 'Rete',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'severity' => 
    array (
      'label' => 'Gravità',
      'help' => 'Livello di gravità del problema',
      'options' => 
      array (
        'low' => 'Bassa',
        'medium' => 'Media',
        'high' => 'Alta',
        'critical' => 'Critica',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'check_all' => 
    array (
      'label' => 'Controlla Tutto',
      'success' => 'Controlli completati con successo',
      'error' => 'Errore durante l\'esecuzione dei controlli',
    ),
    'check_selected' => 
    array (
      'label' => 'Controlla Selezionati',
      'success' => 'Controlli selezionati completati',
      'error' => 'Errore durante l\'esecuzione dei controlli selezionati',
    ),
    'refresh' => 
    array (
      'label' => 'Aggiorna',
      'success' => 'Stato aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento dello stato',
    ),
    'export' => 
    array (
      'label' => 'Esporta Report',
      'success' => 'Report esportato con successo',
      'error' => 'Errore durante l\'esportazione del report',
    ),
    'fix' => 
    array (
      'label' => 'Risolvi Problema',
      'success' => 'Problema risolto con successo',
      'error' => 'Errore durante la risoluzione del problema',
    ),
  ),
  'messages' => 
  array (
    'checks' => 
    array (
      'database' => 
      array (
        'connection' => 'Verifica connessione al database',
        'migrations' => 'Verifica stato migrazioni',
        'tables' => 'Verifica integrità tabelle',
        'indexes' => 'Verifica ottimizzazione indici',
        'deadlocks' => 'Verifica presenza deadlocks',
      ),
      'cache' => 
      array (
        'connection' => 'Verifica connessione alla cache',
        'hits' => 'Analisi cache hits/miss',
        'memory' => 'Monitoraggio utilizzo memoria',
        'keys' => 'Verifica chiavi scadute',
        'fragmentation' => 'Analisi frammentazione',
      ),
      'storage' => 
      array (
        'disk_space' => 'Verifica spazio disponibile',
        'permissions' => 'Verifica permessi directory',
        'write_access' => 'Verifica accesso in scrittura',
        'backup_space' => 'Verifica spazio backup',
        'temp_files' => 'Pulizia file temporanei',
      ),
      'queue' => 
      array (
        'connection' => 'Verifica connessione code',
        'failed_jobs' => 'Analisi job falliti',
        'pending_jobs' => 'Monitoraggio job in attesa',
        'worker_status' => 'Verifica stato workers',
        'retry_jobs' => 'Gestione retry automatici',
      ),
      'services' => 
      array (
        'redis' => 'Verifica stato Redis',
        'elasticsearch' => 'Verifica stato Elasticsearch',
        'email' => 'Verifica configurazione email',
        'scheduler' => 'Verifica scheduler',
        'supervisor' => 'Verifica supervisor',
      ),
      'security' => 
      array (
        'ssl' => 'Verifica certificato SSL',
        'updates' => 'Verifica aggiornamenti sicurezza',
        'vulnerabilities' => 'Scansione vulnerabilità',
        'firewall' => 'Verifica configurazione firewall',
        'permissions' => 'Verifica permessi file',
      ),
    ),
    'status' => 
    array (
      'ok' => 'Tutti i sistemi funzionano correttamente',
      'warning' => 'Rilevati problemi non critici che richiedono attenzione',
      'error' => 'Rilevati problemi critici che richiedono intervento',
      'critical' => 'Sistema compromesso, richiesto intervento immediato',
      'unknown' => 'Stato del sistema non determinabile',
    ),
    'notifications' => 
    array (
      'threshold_exceeded' => 'Soglia :name superata: :value',
      'service_down' => 'Servizio :name non raggiungibile',
      'backup_failed' => 'Backup fallito: :reason',
      'security_breach' => 'Rilevata potenziale violazione sicurezza',
    ),
  ),
  'title' => 'health',
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
