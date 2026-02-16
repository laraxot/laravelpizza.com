<?php

declare(strict_types=1);

return array (
  'administrator' => 'Amministratore',
  'user' => 'Utente',
  'label' => 'Roles',
  'plural_label' => 'Roles (Plurale)',
  'navigation' => 
  array (
    'name' => 'Roles',
    'plural' => 'Roles',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Roles',
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
      'label' => 'Crea Roles',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Roles',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Roles',
    ),
  ),
);
