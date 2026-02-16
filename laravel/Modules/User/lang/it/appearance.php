<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Aspetto',
    'plural' => 'Aspetto',
    'group' => 
    array (
      'name' => 'Aspetto',
      'description' => 'Personalizzazione dell\'aspetto del sistema',
    ),
    'label' => 'Aspetto',
    'icon' => 'heroicon-o-paint-brush',
    'sort' => 5,
  ),
  'label' => 'Appearance',
  'plural_label' => 'Appearance (Plurale)',
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
      'label' => 'Crea Appearance',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Appearance',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Appearance',
    ),
  ),
);
