<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Coordinate GPS',
    'group' => 'Gestione Territorio',
    'icon' => 'heroicon-o-map-pin',
    'sort' => '30',
  ),
  'fields' => 
  array (
    'latitude' => 
    array (
      'label' => 'Latitudine',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'longitude' => 
    array (
      'label' => 'Longitudine',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'select_position' => 'Seleziona Posizione',
    'update_coordinates' => 'Aggiorna Coordinate',
  ),
  'messages' => 
  array (
    'coordinates_updated' => 'Coordinate aggiornate con successo',
    'invalid_coordinates' => 'Coordinate non valide',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
