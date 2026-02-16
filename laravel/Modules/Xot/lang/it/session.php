<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'sessione',
    'plural' => 'sessioni',
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
  'label' => 'Session',
  'plural_label' => 'Session (Plurale)',
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
      'label' => 'Crea Session',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Session',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Session',
    ),
  ),
);
