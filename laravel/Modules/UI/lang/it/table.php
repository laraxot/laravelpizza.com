<?php

declare(strict_types=1);

return array (
  'columns' => 
  array (
    'state_actions' => 
    array (
      'label' => 'Azioni Stato',
      'placeholder' => '',
      'helper_text' => 'Azioni disponibili per la transizione di stato',
    ),
  ),
  'label' => 'Table',
  'plural_label' => 'Table (Plurale)',
  'navigation' => 
  array (
    'name' => 'Table',
    'plural' => 'Table',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Table',
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
      'label' => 'Crea Table',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Table',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Table',
    ),
  ),
);
