<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Provider SSO',
    'group' => 'Authentication',
    'icon' => 'heroicon-o-identification',
    'sort' => 3,
  ),
  'label' => 'Provider SSO',
  'plural_label' => 'Provider SSO',
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
      'label' => 'Crea Sso Provider',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Sso Provider',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Sso Provider',
    ),
  ),
);
