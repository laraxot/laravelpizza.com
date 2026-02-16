<?php

declare(strict_types=1);

return array (
  'pages' => 
  array (
    'artisan-commands-manager' => 
    array (
      'navigation_label' => 'Gestione Artisan',
      'navigation_group' => 'Sistema',
      'navigation_icon' => 'xot::terminal',
      'title' => 'Gestione Comandi Artisan',
      'commands' => 
      array (
        'migrate' => 
        array (
          'label' => 'Migrate Database',
          'icon' => 'xot::database-update',
        ),
        'filament_upgrade' => 
        array (
          'label' => 'Upgrade Filament',
          'icon' => 'xot::upgrade',
        ),
        'filament_optimize' => 
        array (
          'label' => 'Optimize Filament',
          'icon' => 'xot::optimize',
        ),
        'view_cache' => 
        array (
          'label' => 'Cache Views',
          'icon' => 'xot::view-cache',
        ),
        'config_cache' => 
        array (
          'label' => 'Cache Config',
          'icon' => 'xot::config-cache',
        ),
        'route_cache' => 
        array (
          'label' => 'Cache Routes',
          'icon' => 'xot::route-cache',
        ),
        'event_cache' => 
        array (
          'label' => 'Cache Events',
          'icon' => 'xot::event-cache',
        ),
        'queue_restart' => 
        array (
          'label' => 'Restart Queue',
          'icon' => 'xot::queue-restart',
        ),
      ),
      'status' => 
      array (
        'completed' => 'Completato',
        'failed' => 'Fallito',
        'waiting' => 'In attesa dell\'output...',
      ),
      'messages' => 
      array (
        'command_started' => 'Comando avviato',
        'command_completed' => 'Il comando :command è stato eseguito con successo',
        'command_failed' => 'Il comando :command è fallito',
      ),
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
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
