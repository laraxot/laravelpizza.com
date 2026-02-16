<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Unique identifier of the activity',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Description',
      'tooltip' => 'Description of the activity',
      'helper_text' => '',
      'description' => '',
    ),
    'subject_type' => 
    array (
      'label' => 'Subject Type',
      'tooltip' => 'Type of entity subject to the activity',
      'helper_text' => '',
      'description' => '',
    ),
    'subject_id' => 
    array (
      'label' => 'Subject ID',
      'tooltip' => 'Identifier of the entity subject to the activity',
      'helper_text' => '',
      'description' => '',
    ),
    'causer_type' => 
    array (
      'label' => 'Causer Type',
      'tooltip' => 'Type of entity that caused the activity',
      'helper_text' => '',
      'description' => '',
    ),
    'causer_id' => 
    array (
      'label' => 'Causer ID',
      'tooltip' => 'Identifier of the entity that caused the activity',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'tooltip' => 'Date and time when the activity was created',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'View',
      'tooltip' => 'View activity details',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'tooltip' => 'Delete this activity',
      'confirmation' => 'Are you sure you want to delete this activity?',
    ),
  ),
  'filters' => 
  array (
    'date' => 
    array (
      'label' => 'Date',
      'tooltip' => 'Filter by creation date',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'tooltip' => 'Filter by activity type',
    ),
  ),
  'snapshots' => 
  array (
    'fields' => 
    array (
      'id' => 
      array (
        'label' => 'ID',
        'help' => 'Unique identifier of the snapshot',
      ),
      'aggregate_uuid' => 
      array (
        'label' => 'Aggregate UUID',
        'help' => 'UUID of the aggregate',
      ),
      'aggregate_version' => 
      array (
        'label' => 'Aggregate Version',
        'help' => 'Version of the aggregate',
      ),
      'state' => 
      array (
        'label' => 'State',
        'help' => 'State of the snapshot',
      ),
      'created_at' => 
      array (
        'label' => 'Creation Date',
        'help' => 'Creation date of the snapshot',
      ),
      'updated_at' => 
      array (
        'label' => 'Last Update',
        'help' => 'Last update date of the snapshot',
      ),
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
