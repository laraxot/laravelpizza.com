<?php

declare(strict_types=1);

return array (
  'modules_overview' => 
  array (
    'title' => 'Moduli Disponibili',
    'description' => 'Seleziona un modulo per accedere alla sua amministrazione',
    'empty' => 
    array (
      'title' => 'Nessun modulo disponibile',
      'description' => 'Non hai accesso a nessun modulo amministrativo.',
    ),
  ),
  'label' => 'Widgets',
  'plural_label' => 'Widgets (Plurale)',
  'navigation' => 
  array (
    'name' => 'Widgets',
    'plural' => 'Widgets',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Widgets',
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
      'label' => 'Crea Widgets',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Widgets',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Widgets',
    ),
  ),
);
