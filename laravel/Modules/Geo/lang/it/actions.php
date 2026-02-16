<?php

declare(strict_types=1);

return array (
  'update_coordinates' => 
  array (
    'errors' => 
    array (
      'empty_address' => 'Indirizzo vuoto non può essere geocodato',
      'geocoding_failed' => 'Impossibile ottenere le coordinate dall\'indirizzo',
    ),
    'bulk' => 
    array (
      'label' => 'Aggiorna coordinate',
      'errors' => 
      array (
        'generic' => 'Errore durante l\'aggiornamento delle coordinate',
        'record' => 'Errore per :name: :error',
      ),
      'notifications' => 
      array (
        'success' => 
        array (
          'title' => 'Coordinate aggiornate',
          'body' => 'Aggiornate le coordinate di :count record su :total',
        ),
        'warning' => 
        array (
          'title' => 'Alcuni aggiornamenti non sono riusciti',
          'more_errors' => '... e altri :count errori',
        ),
      ),
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
