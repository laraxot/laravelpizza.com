<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'icon' => 'heroicon-o-command-line',
    'group' => 'Sistema',
    'label' => 'Comandi Artisan',
    'sort' => '10',
  ),
  'commands' => 
  array (
    'migrate' => 
    array (
      'label' => 'Migrazione Database',
    ),
    'filament_upgrade' => 
    array (
      'label' => 'Aggiorna Filament',
    ),
    'filament_optimize' => 
    array (
      'label' => 'Ottimizza Filament',
    ),
    'view_cache' => 
    array (
      'label' => 'Cache delle View',
    ),
    'config_cache' => 
    array (
      'label' => 'Cache della Configurazione',
    ),
    'route_cache' => 
    array (
      'label' => 'Cache delle Route',
    ),
    'event_cache' => 
    array (
      'label' => 'Cache degli Eventi',
    ),
    'queue_restart' => 
    array (
      'label' => 'Riavvia Code',
    ),
  ),
  'status' => 
  array (
    'completed' => 'Completato',
    'failed' => 'Fallito',
    'waiting' => 'In attesa dell\'output...',
    'running' => 'In esecuzione...',
  ),
  'messages' => 
  array (
    'command_started' => 'Comando Avviato',
    'command_started_desc' => 'Il comando :command è stato avviato. L\'output apparirà in tempo reale.',
    'command_completed' => 'Comando Completato',
    'command_completed_desc' => 'Il comando :command è stato completato con successo',
    'command_failed' => 'Comando Fallito',
    'command_failed_desc' => 'Il comando :command è fallito. Controlla l\'output per i dettagli.',
  ),
  'hints' => 
  array (
    'running' => 'Il comando è in esecuzione. L\'output apparirà in tempo reale.',
    'disabled' => 'Non è possibile eseguire altri comandi mentre un comando è in esecuzione.',
    'scroll' => 'L\'output si aggiorna automaticamente e scorre verso il basso.',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
  'actions' => 
  array (
  ),
);
