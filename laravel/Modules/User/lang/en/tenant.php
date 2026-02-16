<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Tenant',
    'plural' => 'Tenants',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione dei tenant e delle loro configurazioni',
    ),
    'label' => 'tenant',
    'sort' => '30',
    'icon' => 'user-user-tenant',
  ),
  'table' => 
  array (
    'heading' => 'Tenant',
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'secondary_color' => 
    array (
      'label' => 'secondary_color',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'slug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'id' => 
    array (
      'label' => 'id',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'message' => 
    array (
      'label' => 'message',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'fields' => 
      array (
        'import_file' => 'Seleziona un file XLS o CSV da caricare',
      ),
    ),
    'export' => 
    array (
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 'Nome area',
        'parent_name' => 'Nome area livello superiore',
      ),
    ),
    'change_password' => 'Cambio password',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
