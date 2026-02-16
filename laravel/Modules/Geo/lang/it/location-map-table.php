<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Tabella Posizioni',
    'group' => 'Gestione Territorio',
    'icon' => 'ui-geo-location',
    'sort' => 15,
  ),
  'table' => 
  array (
    'columns' => 
    array (
      'name' => 'Nome',
      'address' => 'Indirizzo',
      'coordinates' => 'Coordinate',
      'actions' => 'Azioni',
    ),
    'filters' => 
    array (
      'with_coordinates' => 'Con coordinate',
      'without_coordinates' => 'Senza coordinate',
    ),
  ),
  'actions' => 
  array (
    'view_on_map' => 'Visualizza sulla mappa',
    'edit_coordinates' => 'Modifica coordinate',
    'export' => 'Esporta dati',
  ),
  'label' => 'Location Map Table',
  'plural_label' => 'Location Map Table (Plurale)',
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
);
