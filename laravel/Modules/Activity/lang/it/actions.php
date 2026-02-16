<?php

declare(strict_types=1);

return array (
  'list_log_activities' => 
  array (
    'label' => 'Cronologia',
    'tooltip' => 'Visualizza storico modifiche',
    'icon' => 'heroicon-o-clock',
    'color' => 'gray',
    'modal' => 
    array (
      'heading' => 'Storico Modifiche',
      'description' => 'Visualizza tutte le modifiche effettuate su questo record',
    ),
    'view_all' => 'Visualizza Tutto',
    'close' => 'Chiudi',
    'messages' => 
    array (
      'no_activities' => 'Nessuna modifica registrata per questo record',
      'loading' => 'Caricamento storico in corso...',
    ),
  ),
  'label' => 'Actions',
  'plural_label' => 'Actions (Plurale)',
  'navigation' => 
  array (
    'name' => 'Actions',
    'plural' => 'Actions',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Actions',
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
      'label' => 'Crea Actions',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Actions',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Actions',
    ),
  ),
);
