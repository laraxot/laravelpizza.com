<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Reset Password',
    'plural' => 'Reset Password',
    'label' => 'Reset Password',
    'group' => 
    array (
      'name' => 'Sicurezza',
      'description' => 'Gestione dei reset password e recupero credenziali',
    ),
    'sort' => 4,
    'icon' => 'heroicon-o-key',
  ),
  'label' => 'Password Reset',
  'plural_label' => 'Password Reset (Plurale)',
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
      'label' => 'Crea Password Reset',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Password Reset',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Password Reset',
    ),
  ),
);
