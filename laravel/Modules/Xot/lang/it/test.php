<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Test',
    'group' => 'Sviluppo',
    'icon' => 'heroicon-o-beaker',
    'sort' => 999,
  ),
  'label' => 'Test',
  'plural_label' => 'Test (Plurale)',
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
      'label' => 'Crea Test',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Test',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Test',
    ),
  ),
);
