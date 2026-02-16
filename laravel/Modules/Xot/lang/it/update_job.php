<?php

declare(strict_types=1);

return array (
  'name' => 'name',
  'value' => 'value',
  'label' => 'Update Job',
  'plural_label' => 'Update Job (Plurale)',
  'navigation' => 
  array (
    'name' => 'Update Job',
    'plural' => 'Update Job',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Update Job',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
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
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Update Job',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Update Job',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Update Job',
    ),
  ),
);
