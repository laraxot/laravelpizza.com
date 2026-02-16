<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Log',
    'plural' => 'Log',
    'group' => 
    array (
      'name' => 'Monitoraggio',
      'description' => 'Gestione dei log di sistema',
    ),
    'label' => 'Log',
    'sort' => 61,
    'icon' => 'activity-log-animated',
  ),
  'fields' => 
  array (
    'level' => 
    array (
      'label' => 'Livello',
      'emergency' => 'Emergency',
      'alert' => 'Alert',
      'critical' => 'Critical',
      'error' => 'Error',
      'warning' => 'Warning',
      'notice' => 'Notice',
      'info' => 'Info',
      'debug' => 'Debug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'context' => 
    array (
      'label' => 'Contesto',
      'exception' => 'Eccezione',
      'stack_trace' => 'Stack Trace',
      'additional' => 'Info Aggiuntive',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'channel' => 
    array (
      'label' => 'Canale',
      'system' => 'Sistema',
      'application' => 'Applicazione',
      'security' => 'Sicurezza',
      'database' => 'Database',
      'queue' => 'Code',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'datetime' => 
    array (
      'label' => 'Data e Ora',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'environment' => 
    array (
      'label' => 'Ambiente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'level' => 'Livello',
    'channel' => 'Canale',
    'date_range' => 'Intervallo Date',
    'environment' => 'Ambiente',
    'search' => 'Cerca nel messaggio',
  ),
  'actions' => 
  array (
    'view_details' => 'Visualizza Dettagli',
    'download' => 'Scarica',
    'clear' => 'Pulisci',
    'archive' => 'Archivia',
  ),
  'messages' => 
  array (
    'no_logs' => 'Nessun log trovato',
    'cleared' => 'Log eliminati con successo',
    'archived' => 'Log archiviati con successo',
    'downloaded' => 'File log scaricato con successo',
  ),
  'badges' => 
  array (
    'level' => 
    array (
      'emergency' => 'Emergenza',
      'alert' => 'Allerta',
      'critical' => 'Critico',
      'error' => 'Errore',
      'warning' => 'Attenzione',
      'notice' => 'Avviso',
      'info' => 'Info',
      'debug' => 'Debug',
    ),
  ),
  'label' => 'Log',
  'plural_label' => 'Log (Plurale)',
);
