<?php

declare(strict_types=1);

return array (
  'draft' => 
  array (
    'label' => 'Bozza',
    'color' => 'gray',
  ),
  'EventScheduled' => 
  array (
    'label' => 'Programmato',
    'color' => 'success',
  ),
  'EventScheduled_confirmed' => 
  array (
    'label' => 'Confermato',
    'color' => 'success',
  ),
  'EventCancelled' => 
  array (
    'label' => 'Cancellato',
    'color' => 'danger',
  ),
  'EventPostponed' => 
  array (
    'label' => 'Rinviato',
    'color' => 'warning',
  ),
  'EventRescheduled' => 
  array (
    'label' => 'Riprogrammato',
    'color' => 'info',
  ),
  'EventMovedOnline' => 
  array (
    'label' => 'Spostato Online',
    'color' => 'primary',
  ),
  'completed' => 
  array (
    'label' => 'Completato',
    'color' => 'success',
  ),
  'label' => 'Event Status',
  'plural_label' => 'Event Status (Plurale)',
  'navigation' => 
  array (
    'name' => 'Event Status',
    'plural' => 'Event Status',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Event Status',
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
      'label' => 'Crea Event Status',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Event Status',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Event Status',
    ),
  ),
);
