<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Interfaccia',
    'plural' => 'Interfacce',
    'group' => 'Sistema',
    'label' => 'ui',
    'sort' => 70,
    'icon' => 'heroicon-o-squares-2x2',
  ),
  'label' => 'Ui',
  'plural_label' => 'Ui (Plurale)',
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
      'label' => 'Crea Ui',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Ui',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Ui',
    ),
  ),
);
