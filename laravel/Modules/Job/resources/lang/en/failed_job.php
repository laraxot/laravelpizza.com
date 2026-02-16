<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Failed Job',
    'group' => 'Failed Jobs',
    'icon' => 'heroicon-o-exclamation-triangle',
    'sort' => 27,
  ),
  'label' => 'Failed Job',
  'plural_label' => 'Failed Jobs',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'connection' => 
    array (
      'label' => 'Connection',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Queue',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Payload',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'exception' => 
    array (
      'label' => 'Exception',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_at' => 
    array (
      'label' => 'Failed At',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'retry' => 
    array (
      'label' => 'Retry',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
    ),
    'retry_all' => 
    array (
      'label' => 'Retry All',
    ),
    'delete_all' => 
    array (
      'label' => 'Delete All',
    ),
  ),
);
