<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Tabella Posizioni',
    'group' => 'Gestione Territorio',
    'icon' => 'ui-geo-location',
    'sort' => '15',
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
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
);
