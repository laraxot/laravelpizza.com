<?php

declare(strict_types=1);

return array (
  'pages' => 'Pages',
  'widgets' => 'Widgets',
  'navigation' => 
  array (
    'name' => 'Media',
    'plural' => 'Media',
    'group' => 
    array (
      'name' => 'System',
      'description' => 'Multimedia file management',
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
      'label' => 'Collection',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'filename' => 
    array (
      'label' => 'Filename',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'mime_type' => 
    array (
      'label' => 'Type',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'human_readable_size' => 
    array (
      'label' => 'Size',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'permissions' => 
    array (
      'label' => 'Permissions',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Updated at',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'First Name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'select_all' => 
    array (
      'name' => 'Select All',
      'message' => '',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'creator' => 
    array (
      'name' => 'Creator',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'uploaded_at' => 
    array (
      'label' => 'Uploaded at',
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
        'import_file' => 'Select an XLS or CSV file to upload',
      ),
    ),
    'export' => 
    array (
      'filename_prefix' => 'Areas at',
      'columns' => 
      array (
        'name' => 'Area name',
        'parent_name' => 'Parent area name',
      ),
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
