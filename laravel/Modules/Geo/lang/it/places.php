<?php

declare(strict_types=1);

return array (
  'tab' => 
  array (
    'index' => 'Lista',
    'create' => 'Aggiungi Luogo',
    'edit' => 'Modifica Luogo',
  ),
  'label' => 'Places',
  'plural_label' => 'Places (Plurale)',
  'navigation' => 
  array (
    'name' => 'Places',
    'plural' => 'Places',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Places',
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
      'label' => 'Crea Places',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Places',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Places',
    ),
  ),
);
