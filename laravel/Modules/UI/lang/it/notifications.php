<?php

declare(strict_types=1);

return array (
  'state_transition' => 
  array (
    'success' => 
    array (
      'title' => 'Transizione Completata',
      'body' => 'Lo stato è stato cambiato a ":state" con successo.',
    ),
    'error' => 
    array (
      'title' => 'Errore Transizione',
      'body' => 'Si è verificato un errore durante la transizione di stato: :error',
    ),
  ),
  'label' => 'Notifications',
  'plural_label' => 'Notifications (Plurale)',
  'navigation' => 
  array (
    'name' => 'Notifications',
    'plural' => 'Notifications',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Notifications',
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
      'label' => 'Crea Notifications',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Notifications',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Notifications',
    ),
  ),
);
