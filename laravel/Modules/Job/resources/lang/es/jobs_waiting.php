<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Trabajos en Espera',
    'group' => 'Trabajos',
    'icon' => 'heroicon-o-clock',
    'sort' => 30,
  ),
  'label' => 'Trabajo en Espera',
  'plural_label' => 'Trabajos en Espera',
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
    'attempts' => 
    array (
      'label' => 'Intentos',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'reserved_at' => 
    array (
      'label' => 'Reservado En',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'available_at' => 
    array (
      'label' => 'Disponible En',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creado En',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'process' => 
    array (
      'label' => 'Procesar',
    ),
    'retry' => 
    array (
      'label' => 'Reintentar',
    ),
  ),
);
