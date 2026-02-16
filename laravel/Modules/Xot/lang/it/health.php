<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Salute',
    'plural' => 'Salute',
    'group' => 
    array (
      'name' => 'Admin',
    ),
  ),
  'pages' => 
  array (
    'health_check_results' => 
    array (
      'buttons' => 
      array (
        'refresh' => 'Refresh',
      ),
      'heading' => 'Application Health',
      'navigation' => 
      array (
        'group' => 'Settings',
        'label' => 'Application Health',
      ),
      'notifications' => 
      array (
        'check_results' => 'Check results from',
      ),
    ),
  ),
  'actions' => 
  array (
    'refresh' => 
    array (
      'label' => 'refresh',
      'tooltip' => 'refresh',
      'icon' => 'refresh',
    ),
    'logout' => 
    array (
      'tooltip' => 'logout',
    ),
  ),
  'label' => 'Health',
  'plural_label' => 'Health (Plurale)',
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
);
