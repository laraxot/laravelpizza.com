<?php

declare(strict_types=1);

return array (
  'label' => 'Genere',
  'options' => 
  array (
    'f' => 'Femmina',
    'm' => 'Maschio',
  ),
  'plural_label' => 'Gender Enum (Plurale)',
  'navigation' => 
  array (
    'name' => 'Gender Enum',
    'plural' => 'Gender Enum',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Gender Enum',
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
      'label' => 'Crea Gender Enum',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Gender Enum',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Gender Enum',
    ),
  ),
);
