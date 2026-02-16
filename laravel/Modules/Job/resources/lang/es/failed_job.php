<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Trabajo Fallido',
    'group' => 'Trabajos Fallidos',
    'icon' => 'heroicon-o-exclamation-triangle',
    'sort' => 27,
  ),
  'label' => 'Trabajo Fallido',
  'plural_label' => 'Trabajos Fallidos',
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
      'label' => 'Conexión',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'queue' => 
    array (
      'label' => 'Cola',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'payload' => 
    array (
      'label' => 'Carga Útil',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'exception' => 
    array (
      'label' => 'Excepción',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'failed_at' => 
    array (
      'label' => 'Fallido En',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'retry' => 
    array (
      'label' => 'Reintentar',
    ),
    'delete' => 
    array (
      'label' => 'Eliminar',
    ),
    'retry_all' => 
    array (
      'label' => 'Reintentar Todos',
    ),
    'delete_all' => 
    array (
      'label' => 'Eliminar Todos',
    ),
  ),
);
