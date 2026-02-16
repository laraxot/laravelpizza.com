<?php

declare(strict_types=1);

return array (
  'P1D' => 
  array (
    'label' => 'Giornaliero',
    'color' => 'info',
  ),
  'P1W' => 
  array (
    'label' => 'Settimanale',
    'color' => 'success',
  ),
  'P2W' => 
  array (
    'label' => 'Ogni 2 Settimane',
    'color' => 'warning',
  ),
  'P1M' => 
  array (
    'label' => 'Mensile',
    'color' => 'primary',
  ),
  'P1Y' => 
  array (
    'label' => 'Annuale',
    'color' => 'gray',
  ),
  'label' => 'Repeat Frequency',
  'plural_label' => 'Repeat Frequency (Plurale)',
  'navigation' => 
  array (
    'name' => 'Repeat Frequency',
    'plural' => 'Repeat Frequency',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Repeat Frequency',
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
      'label' => 'Crea Repeat Frequency',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Repeat Frequency',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Repeat Frequency',
    ),
  ),
);
