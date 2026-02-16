<?php

declare(strict_types=1);

return array (
  'label' => 'Motore PDF',
  'options' => 
  array (
    'spipu' => 'Spipu',
    'spatie' => 'Spatie',
  ),
  'plural_label' => 'Pdf Engine Enum (Plurale)',
  'navigation' => 
  array (
    'name' => 'Pdf Engine Enum',
    'plural' => 'Pdf Engine Enum',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Pdf Engine Enum',
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
      'label' => 'Crea Pdf Engine Enum',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Pdf Engine Enum',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Pdf Engine Enum',
    ),
  ),
);
