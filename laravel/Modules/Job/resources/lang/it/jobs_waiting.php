<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Lavori in attesa',
    'group' => 'Lavori',
    'icon' => 'heroicon-o-clock',
    'sort' => 30,
  ),
  'label' => 'Lavoro in attesa',
  'plural_label' => 'Lavori in attesa',
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
      'label' => 'Connessione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Coda',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Contenuto',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'attempts' => 
    array (
      'label' => 'Tentativi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Riservato il',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Disponibile il',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creato il',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'process' => 
    array (
      'label' => 'Elabora',
    ),
    'retry' => 
    array (
      'label' => 'Riprova',
    ),
  ),
);
