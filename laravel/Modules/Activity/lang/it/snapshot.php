<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Snapshot',
    'plural' => 'Snapshots',
    'group' => 
    array (
      'name' => 'Monitoraggio',
      'description' => 'Gestione degli snapshot di sistema',
    ),
    'label' => 'Snapshot',
    'sort' => 63,
    'icon' => 'activity-snapshot-animated',
  ),
  'fields' => 
  array (
    'model_type' => 
    array (
      'label' => 'model_type',
      'placeholder' => 'model_type',
      'helper_text' => 'model_type',
      'description' => 'model_type',
      'tooltip' => '',
    ),
    'model_id' => 
    array (
      'label' => 'model_id',
      'placeholder' => 'model_id',
      'helper_text' => 'model_id',
      'description' => 'model_id',
      'tooltip' => '',
    ),
    'state' => 
    array (
      'label' => 'state',
      'placeholder' => 'state',
      'helper_text' => 'state',
      'description' => 'state',
      'tooltip' => '',
    ),
    'created_by_type' => 
    array (
      'label' => 'created_by_type',
      'placeholder' => 'created_by_type',
      'helper_text' => 'created_by_type',
      'description' => 'created_by_type',
      'tooltip' => '',
    ),
    'created_by_id' => 
    array (
      'label' => 'created_by_id',
      'placeholder' => 'created_by_id',
      'helper_text' => 'created_by_id',
      'description' => 'created_by_id',
      'tooltip' => '',
    ),
  ),
  'label' => 'Snapshot',
  'plural_label' => 'Snapshot (Plurale)',
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Snapshot',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Snapshot',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Snapshot',
    ),
  ),
);
