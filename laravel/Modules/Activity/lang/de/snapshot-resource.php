<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificativo univoco dello snapshot',
      'helper_text' => '',
      'description' => '',
    ),
    'aggregate_uuid' => 
    array (
      'label' => 'UUID Aggregato',
      'tooltip' => 'Identificativo univoco dell\'aggregato',
      'helper_text' => '',
      'description' => '',
    ),
    'aggregate_version' => 
    array (
      'label' => 'Versione Aggregato',
      'tooltip' => 'Numero di versione dell\'aggregato',
      'helper_text' => '',
      'description' => '',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Stato corrente dello snapshot',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => 'Data e ora di creazione dello snapshot',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli dello snapshot',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina questo snapshot',
      'confirmation' => 'Sei sicuro di voler eliminare questo snapshot?',
    ),
  ),
  'filters' => 
  array (
    'date' => 
    array (
      'label' => 'Data',
      'tooltip' => 'Filtra per data di creazione',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Filtra per stato',
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
);
