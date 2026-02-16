<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Wartende Aufträge',
    'group' => 'Aufträge',
    'icon' => 'heroicon-o-clock',
    'sort' => 30,
  ),
  'label' => 'Wartender Auftrag',
  'plural_label' => 'Wartende Aufträge',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'connection' => 
    array (
      'label' => 'Verbindung',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Warteschlange',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Nutzlast',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Versuche',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'display_name' => 
    array (
      'label' => 'Anzeigename',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Reserviert Am',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Verfügbar Am',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Erstellt Am',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'process' => 
    array (
      'label' => 'Verarbeiten',
    ),
    'retry' => 
    array (
      'label' => 'Wiederholen',
    ),
  ),
);
