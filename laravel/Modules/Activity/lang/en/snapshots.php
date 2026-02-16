<?php

declare(strict_types=1);

return array (
  'name' => 'Snapshots',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Snapshot ID',
      'helper_text' => 'Unique identifier of the snapshot',
      'tooltip' => '',
      'description' => '',
    ),
    'aggregate_uuid' => 
    array (
      'label' => 'Aggregate UUID',
      'placeholder' => 'Aggregate UUID',
      'helper_text' => 'Unique identifier of the aggregate',
      'tooltip' => '',
      'description' => '',
    ),
    'aggregate_version' => 
    array (
      'label' => 'Version',
      'placeholder' => 'Aggregate version',
      'helper_text' => 'Version number of the aggregate',
      'tooltip' => '',
      'description' => '',
    ),
    'state' => 
    array (
      'label' => 'State',
      'placeholder' => 'Snapshot state',
      'helper_text' => 'Current state of the snapshot',
      'tooltip' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'helper_text' => 'Creation date of the snapshot',
      'tooltip' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Last Modified',
      'helper_text' => 'Last modification date',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'New Snapshot',
      'tooltip' => 'Create a new snapshot',
    ),
    'edit' => 
    array (
      'label' => 'Edit',
      'tooltip' => 'Edit snapshot',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'tooltip' => 'Delete snapshot',
    ),
    'view' => 
    array (
      'label' => 'View',
      'tooltip' => 'View snapshot details',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Snapshot created successfully',
      'updated' => 'Snapshot updated successfully',
      'deleted' => 'Snapshot deleted successfully',
    ),
    'error' => 
    array (
      'create' => 'Error while creating snapshot',
      'update' => 'Error while updating snapshot',
      'delete' => 'Error while deleting snapshot',
    ),
    'confirm' => 
    array (
      'delete' => 'Are you sure you want to delete this snapshot?',
    ),
  ),
  'filters' => 
  array (
    'aggregate_type' => 
    array (
      'label' => 'Aggregate Type',
      'options' => 
      array (
        'user' => 'User',
        'profile' => 'Profile',
        'role' => 'Role',
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
