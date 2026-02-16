<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Unique identifier of the snapshot',
      'helper_text' => '',
      'description' => '',
    ),
    'aggregate_uuid' => 
    array (
      'label' => 'Aggregate UUID',
      'tooltip' => 'Unique identifier of the aggregate',
      'helper_text' => '',
      'description' => '',
    ),
    'aggregate_version' => 
    array (
      'label' => 'Aggregate Version',
      'tooltip' => 'Version number of the aggregate',
      'helper_text' => '',
      'description' => '',
    ),
    'state' => 
    array (
      'label' => 'State',
      'tooltip' => 'Current state of the snapshot',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'tooltip' => 'Date and time when the snapshot was created',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'view' => 
    array (
      'label' => 'View',
      'tooltip' => 'View snapshot details',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'tooltip' => 'Delete this snapshot',
      'confirmation' => 'Are you sure you want to delete this snapshot?',
    ),
  ),
  'filters' => 
  array (
    'date' => 
    array (
      'label' => 'Date',
      'tooltip' => 'Filter by creation date',
    ),
    'state' => 
    array (
      'label' => 'State',
      'tooltip' => 'Filter by state',
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
