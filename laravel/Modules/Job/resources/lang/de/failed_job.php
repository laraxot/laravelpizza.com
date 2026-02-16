<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Fehlgeschlagener Auftrag',
    'group' => 'Fehlgeschlagene Aufträge',
    'icon' => 'heroicon-o-exclamation-triangle',
    'sort' => 27,
  ),
  'label' => 'Fehlgeschlagener Auftrag',
  'plural_label' => 'Fehlgeschlagene Aufträge',
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
    'exception' => 
    array (
      'label' => 'Ausnahme',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_at' => 
    array (
      'label' => 'Fehlgeschlagen Am',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'retry' => 
    array (
      'label' => 'Wiederholen',
    ),
    'delete' => 
    array (
      'label' => 'Löschen',
    ),
    'retry_all' => 
    array (
      'label' => 'Alle Wiederholen',
    ),
    'delete_all' => 
    array (
      'label' => 'Alle Löschen',
    ),
  ),
);
