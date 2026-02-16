<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Authentication Logs',
    'group' => 'Authentication',
    'icon' => 'heroicon-o-shield-check',
    'sort' => 5,
  ),
  'actions' => 
  array (
    'reorderRecords' => 
    array (
      'tooltip' => 'reorderRecords',
      'icon' => 'reorderRecords',
      'label' => 'reorderRecords',
    ),
  ),
  'label' => 'Authentication Log',
  'plural_label' => 'Authentication Log (Plurale)',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
);
