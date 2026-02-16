<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Log',
    'plural' => 'Logs',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione e monitoraggio dei log di sistema',
    ),
    'label' => 'log',
    'sort' => '15',
    'icon' => 'xot-log',
  ),
  'fields' => 
  array (
    'level' => 
    array (
      'label' => 'Livello',
      'placeholder' => 'Seleziona il livello',
      'help' => 'Livello di gravità del log',
      'options' => 
      array (
        'debug' => 'Debug',
        'info' => 'Informazione',
        'notice' => 'Avviso',
        'warning' => 'Attenzione',
        'error' => 'Errore',
        'critical' => 'Critico',
        'alert' => 'Allarme',
        'emergency' => 'Emergenza',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Contenuto del messaggio',
      'help' => 'Descrizione dettagliata dell\'evento registrato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'context' => 
    array (
      'label' => 'Contesto',
      'placeholder' => 'Informazioni contestuali',
      'help' => 'Dati aggiuntivi relativi all\'evento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'channel' => 
    array (
      'label' => 'Canale',
      'placeholder' => 'Seleziona il canale',
      'help' => 'Canale di registrazione del log',
      'options' => 
      array (
        'stack' => 'Stack',
        'single' => 'File Singolo',
        'daily' => 'Giornaliero',
        'slack' => 'Slack',
        'syslog' => 'Syslog',
        'errorlog' => 'Error Log',
        'papertrail' => 'Papertrail',
        'discord' => 'Discord',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timestamp' => 
    array (
      'label' => 'Data e Ora',
      'help' => 'Momento esatto della registrazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'file' => 
    array (
      'label' => 'File',
      'help' => 'File sorgente dell\'evento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'line' => 
    array (
      'label' => 'Linea',
      'help' => 'Numero di linea nel file sorgente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'stack_trace' => 
    array (
      'label' => 'Stack Trace',
      'help' => 'Traccia dello stack per debug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user' => 
    array (
      'label' => 'Utente',
      'help' => 'Utente che ha generato l\'evento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ip' => 
    array (
      'label' => 'Indirizzo IP',
      'help' => 'IP di origine dell\'evento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_agent' => 
    array (
      'label' => 'User Agent',
      'help' => 'Browser o applicazione client',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizza',
      'success' => 'Log visualizzato con successo',
      'error' => 'Errore durante la visualizzazione del log',
    ),
    'download' => 
    array (
      'label' => 'Scarica',
      'success' => 'Log scaricato con successo',
      'error' => 'Errore durante il download del log',
    ),
    'clear' => 
    array (
      'label' => 'Svuota',
      'success' => 'Log svuotati con successo',
      'error' => 'Errore durante la pulizia dei log',
      'confirm' => 'Sei sicuro di voler eliminare tutti i log?',
    ),
    'search' => 
    array (
      'label' => 'Cerca',
      'placeholder' => 'Cerca nei log...',
      'help' => 'Ricerca full-text nei messaggi di log',
    ),
    'filter' => 
    array (
      'label' => 'Filtra',
      'placeholder' => 'Filtra per livello...',
      'help' => 'Filtra i log per livello di gravità',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'filename_prefix' => 'Log_Sistema_',
      'success' => 'Log esportati con successo',
      'error' => 'Errore durante l\'esportazione dei log',
    ),
    'archive' => 
    array (
      'label' => 'Archivia',
      'success' => 'Log archiviati con successo',
      'error' => 'Errore durante l\'archiviazione dei log',
    ),
  ),
  'messages' => 
  array (
    'empty' => 'Nessun log trovato nel periodo selezionato',
    'cleared' => 'I log sono stati svuotati correttamente',
    'archived' => 'I log sono stati archiviati correttamente',
    'errors' => 
    array (
      'download' => 'Impossibile scaricare il file di log',
      'clear' => 'Impossibile svuotare i log',
      'permission' => 'Permessi insufficienti per gestire i log',
      'file_corrupted' => 'Il file di log risulta corrotto',
      'disk_full' => 'Spazio su disco insufficiente',
    ),
    'warnings' => 
    array (
      'size' => 'I file di log occupano molto spazio',
      'rotation' => 'La rotazione dei log potrebbe fallire',
      'old_logs' => 'Presenza di log molto vecchi',
    ),
  ),
  'settings' => 
  array (
    'retention' => 
    array (
      'label' => 'Periodo di conservazione',
      'help' => 'Giorni di mantenimento dei log',
      'options' => 
      array (
        7 => '1 settimana',
        14 => '2 settimane',
        30 => '1 mese',
        90 => '3 mesi',
        180 => '6 mesi',
        365 => '1 anno',
      ),
    ),
    'max_files' => 
    array (
      'label' => 'Numero massimo file',
      'help' => 'Limite di file di log da mantenere',
      'placeholder' => 'Inserisci il numero massimo',
    ),
    'rotation' => 
    array (
      'label' => 'Rotazione',
      'help' => 'Impostazioni di rotazione dei log',
      'options' => 
      array (
        'size' => 'Per dimensione',
        'time' => 'Per tempo',
        'both' => 'Entrambi',
      ),
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
