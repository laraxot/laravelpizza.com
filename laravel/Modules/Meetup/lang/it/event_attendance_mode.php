<?php

declare(strict_types=1);

return array (
  'OfflineEventAttendanceMode' => 
  array (
    'label' => 'In Presenza',
    'color' => 'primary',
    'icon' => 'heroicon-o-map-pin',
  ),
  'OnlineEventAttendanceMode' => 
  array (
    'label' => 'Online',
    'color' => 'success',
    'icon' => 'heroicon-o-computer-desktop',
  ),
  'MixedEventAttendanceMode' => 
  array (
    'label' => 'Mista',
    'color' => 'warning',
    'icon' => 'heroicon-o-arrows-right-left',
  ),
  'label' => 'Event Attendance Mode',
  'plural_label' => 'Event Attendance Mode (Plurale)',
  'navigation' => 
  array (
    'name' => 'Event Attendance Mode',
    'plural' => 'Event Attendance Mode',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Event Attendance Mode',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Event Attendance Mode',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Event Attendance Mode',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Event Attendance Mode',
    ),
  ),
);
