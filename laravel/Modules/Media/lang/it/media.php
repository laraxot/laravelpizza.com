<?php

declare(strict_types=1);

return array (
  'pages' => 'Pagine',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Media',
    'plural' => 'Media',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione dei file multimediali',
    ),
    'label' => 'media',
    'sort' => 20,
    'icon' => 'media-main-animated',
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
    'collection_name' => 
    array (
      'label' => 'Collezione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'filename' => 
    array (
      'label' => 'Nome File',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'mime_type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'human_readable_size' => 
    array (
      'label' => 'Dimensione',
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
    'creator' => 
    array (
      'name' => 'Creatore',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'uploaded_at' => 
    array (
      'label' => 'Caricato il',
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
  ),
  'model' => 
  array (
    'label' => 'media.model',
  ),
  'label' => 'Media',
  'plural_label' => 'Media (Plurale)',
);
