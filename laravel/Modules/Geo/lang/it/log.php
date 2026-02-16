<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'level' => 
    array (
      'label' => 'Livello',
      'placeholder' => 'Seleziona il livello di log',
      'help' => 'Livello di severità del log',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci il messaggio di log',
      'help' => 'Messaggio descrittivo del log',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'context' => 
    array (
      'label' => 'Contesto',
      'placeholder' => 'Inserisci il contesto del log',
      'help' => 'Contesto aggiuntivo per il log',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'channel' => 
    array (
      'label' => 'Canale',
      'placeholder' => 'Seleziona il canale di log',
      'help' => 'Canale di log da utilizzare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'file' => 
    array (
      'label' => 'File',
      'placeholder' => 'Seleziona il file di log',
      'help' => 'File di log da utilizzare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'max_files' => 
    array (
      'label' => 'File massimi',
      'placeholder' => 'Inserisci il numero massimo di file',
      'help' => 'Numero massimo di file di log da mantenere',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'max_size' => 
    array (
      'label' => 'Dimensione massima',
      'placeholder' => 'Inserisci la dimensione massima in MB',
      'help' => 'Dimensione massima per file di log in MB',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'retention_days' => 
    array (
      'label' => 'Giorni di retention',
      'placeholder' => 'Inserisci il numero di giorni',
      'help' => 'Numero di giorni per mantenere i log',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'level_required' => 'Il livello è obbligatorio',
    'level_invalid' => 'Il livello non è valido',
    'message_required' => 'Il messaggio è obbligatorio',
    'message_min_length' => 'Il messaggio deve essere di almeno 3 caratteri',
    'message_max_length' => 'Il messaggio non può superare 1000 caratteri',
    'channel_required' => 'Il canale è obbligatorio',
    'channel_invalid' => 'Il canale non è valido',
    'file_required' => 'Il file è obbligatorio',
    'file_invalid' => 'Il file non è valido',
    'max_files_numeric' => 'Il numero di file massimi deve essere numerico',
    'max_files_min' => 'Il numero di file massimi deve essere almeno 1',
    'max_files_max' => 'Il numero di file massimi non può superare 100',
    'max_size_numeric' => 'La dimensione massima deve essere numerica',
    'max_size_min' => 'La dimensione massima deve essere almeno 1 MB',
    'max_size_max' => 'La dimensione massima non può superare 1000 MB',
    'retention_days_numeric' => 'I giorni di retention devono essere numerici',
    'retention_days_min' => 'I giorni di retention devono essere almeno 1',
    'retention_days_max' => 'I giorni di retention non possono superare 365',
  ),
  'messages' => 
  array (
    'log_created' => 'Log creato con successo',
    'log_updated' => 'Log aggiornato con successo',
    'log_deleted' => 'Log eliminato con successo',
    'logs_cleared' => 'Log svuotati con successo',
    'logs_rotated' => 'Log ruotati con successo',
    'logs_archived' => 'Log archiviati con successo',
    'logs_exported' => 'Log esportati con successo',
    'logs_imported' => 'Log importati con successo',
    'logs_backed_up' => 'Log sottoposti a backup con successo',
    'logs_restored' => 'Log ripristinati con successo',
  ),
  'errors' => 
  array (
    'log_creation_failed' => 'Impossibile creare il log',
    'log_update_failed' => 'Impossibile aggiornare il log',
    'log_deletion_failed' => 'Impossibile eliminare il log',
    'logs_clear_failed' => 'Impossibile svuotare i log',
    'logs_rotation_failed' => 'Impossibile ruotare i log',
    'logs_archiving_failed' => 'Impossibile archiviare i log',
    'logs_export_failed' => 'Impossibile esportare i log',
    'logs_import_failed' => 'Impossibile importare i log',
    'logs_backup_failed' => 'Impossibile sottoporre i log a backup',
    'logs_restore_failed' => 'Impossibile ripristinare i log',
    'file_not_writable' => 'File non scrivibile',
    'file_not_readable' => 'File non leggibile',
    'directory_not_writable' => 'Directory non scrivibile',
    'directory_not_readable' => 'Directory non leggibile',
    'disk_space_insufficient' => 'Spazio su disco insufficiente',
    'permission_denied' => 'Permesso negato',
  ),
  'log_levels' => 
  array (
    'emergency' => 'Emergenza',
    'alert' => 'Allerta',
    'critical' => 'Critico',
    'error' => 'Errore',
    'warning' => 'Avviso',
    'notice' => 'Nota',
    'info' => 'Informazione',
    'debug' => 'Debug',
  ),
  'log_channels' => 
  array (
    'stack' => 'Stack',
    'single' => 'Singolo',
    'daily' => 'Giornaliero',
    'slack' => 'Slack',
    'papertrail' => 'Papertrail',
    'stderr' => 'Stderr',
    'syslog' => 'Syslog',
    'errorlog' => 'Error Log',
    'monolog' => 'Monolog',
    'custom' => 'Personalizzato',
  ),
  'log_operations' => 
  array (
    'create' => 'Crea',
    'read' => 'Leggi',
    'update' => 'Aggiorna',
    'delete' => 'Elimina',
    'clear' => 'Svuota',
    'rotate' => 'Ruota',
    'archive' => 'Archivia',
    'export' => 'Esporta',
    'import' => 'Importa',
    'backup' => 'Backup',
    'restore' => 'Ripristina',
    'search' => 'Cerca',
    'filter' => 'Filtra',
    'sort' => 'Ordina',
    'paginate' => 'Paginazione',
  ),
  'log_formats' => 
  array (
    'json' => 'JSON',
    'xml' => 'XML',
    'csv' => 'CSV',
    'txt' => 'Testo',
    'log' => 'Log',
    'html' => 'HTML',
    'pdf' => 'PDF',
  ),
  'label' => 'Log',
  'plural_label' => 'Log (Plurale)',
  'navigation' => 
  array (
    'name' => 'Log',
    'plural' => 'Log',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Log',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Log',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Log',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Log',
    ),
  ),
);
