<?php

declare(strict_types=1);

return array (
  'pages' => 'Seiten',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Medien',
    'plural' => 'Medien',
    'group' => 
    array (
      'name' => 'System',
      'description' => 'Multimedia-Dateiverwaltung',
    ),
    'label' => 'media',
    'sort' => '20',
    'icon' => 'media-main-animated',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
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
      'label' => 'Sammlung',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'filename' => 
    array (
      'label' => 'Dateiname',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'mime_type' => 
    array (
      'label' => 'Typ',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'human_readable_size' => 
    array (
      'label' => 'Größe',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Berechtigungen',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aktualisiert am',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Vorname',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Nachname',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'select_all' => 
    array (
      'name' => 'Alle auswählen',
      'message' => '',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'creator' => 
    array (
      'name' => 'Ersteller',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'uploaded_at' => 
    array (
      'label' => 'Hochgeladen am',
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
        'import_file' => 'Wählen Sie eine XLS- oder CSV-Datei zum Hochladen aus',
      ),
    ),
    'export' => 
    array (
      'filename_prefix' => 'Bereiche am',
      'columns' => 
      array (
        'name' => 'Bereichsname',
        'parent_name' => 'Übergeordneter Bereichsname',
      ),
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
