<?php

declare(strict_types=1);

return array (
  'model' => 
  array (
    'label' => 'Profilo Base',
  ),
  'navigation' => 
  array (
    'name' => 'Profilo',
    'plural' => 'Profili',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione dei profili',
    ),
    'label' => 'profili',
    'sort' => 31,
    'icon' => 'user-user-permission',
  ),
  'label' => 'Base Profile',
  'plural_label' => 'Base Profile (Plurale)',
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
      'label' => 'Crea Base Profile',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Base Profile',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Base Profile',
    ),
  ),
);
