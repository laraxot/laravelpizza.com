<?php

declare(strict_types=1);

return array (
  'resources' => 'Risorse',
  'pages' => 'Pagine',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Social Provider',
    'plural' => 'Social Providers',
    'group' => 
    array (
      'name' => 'Gestione Utenti',
      'description' => 'Gestione dei provider social',
    ),
    'label' => 'social provider',
    'sort' => '93',
    'icon' => 'user-user-social',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
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
    'select_all' => 
    array (
      'name' => 'Seleziona Tutti',
      'message' => '',
      'label' => '',
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
    'create' => 
    array (
      'label' => 'create',
    ),
  ),
  'plural' => 
  array (
    'model' => 
    array (
      'label' => 'social provider.plural.model',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
