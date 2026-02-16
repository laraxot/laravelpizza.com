<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'view',
    ),
    'delete' => 
    array (
      'label' => 'delete',
    ),
  ),
  'navigation' => 
  array (
    'name' => 'Edit Team',
    'plural' => 'Edit Team',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Edit Team',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'label' => 'Edit Team',
  'plural_label' => 'Edit Team (Plurale)',
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
