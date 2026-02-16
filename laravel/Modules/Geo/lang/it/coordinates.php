<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'latitude' => 
    array (
      'label' => 'Latitudine',
      'placeholder' => 'Inserisci la latitudine',
      'help' => 'Coordinate geografiche - latitudine',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'longitude' => 
    array (
      'label' => 'Longitudine',
      'placeholder' => 'Inserisci la longitudine',
      'help' => 'Coordinate geografiche - longitudine',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'altitude' => 
    array (
      'label' => 'Altitudine',
      'placeholder' => 'Inserisci l\'altitudine',
      'help' => 'Altitudine sopra il livello del mare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'accuracy' => 
    array (
      'label' => 'Precisione',
      'placeholder' => 'Seleziona la precisione',
      'help' => 'Livello di precisione delle coordinate',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'coordinate_system' => 
    array (
      'label' => 'Sistema di coordinate',
      'placeholder' => 'Seleziona il sistema',
      'help' => 'Sistema di coordinate utilizzato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'datum' => 
    array (
      'label' => 'Datum',
      'placeholder' => 'Seleziona il datum',
      'help' => 'Datum geodetico di riferimento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'zone' => 
    array (
      'label' => 'Zona',
      'placeholder' => 'Inserisci la zona',
      'help' => 'Zona UTM o altro sistema',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'easting' => 
    array (
      'label' => 'Est',
      'placeholder' => 'Inserisci la coordinata est',
      'help' => 'Coordinata est nel sistema UTM',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'northing' => 
    array (
      'label' => 'Nord',
      'placeholder' => 'Inserisci la coordinata nord',
      'help' => 'Coordinata nord nel sistema UTM',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'latitude_required' => 'La latitudine è obbligatoria',
    'longitude_required' => 'La longitudine è obbligatoria',
    'latitude_range' => 'La latitudine deve essere tra -90 e 90',
    'longitude_range' => 'La longitudine deve essere tra -180 e 180',
    'altitude_range' => 'L\'altitudine deve essere tra -10000 e 10000',
    'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
  ),
  'messages' => 
  array (
    'coordinates_created' => 'Coordinate create con successo',
    'coordinates_updated' => 'Coordinate aggiornate con successo',
    'coordinates_deleted' => 'Coordinate eliminate con successo',
    'coordinates_converted' => 'Coordinate convertite con successo',
    'coordinates_validated' => 'Coordinate validate con successo',
    'format_changed' => 'Formato delle coordinate cambiato con successo',
  ),
  'coordinate_systems' => 
  array (
    'wgs84' => 'WGS84',
    'nad83' => 'NAD83',
    'etrs89' => 'ETRS89',
    'osgb36' => 'OSGB36',
    'custom' => 'Personalizzato',
  ),
  'accuracy_levels' => 
  array (
    'exact' => 'Esatto',
    'high' => 'Alto',
    'medium' => 'Medio',
    'low' => 'Basso',
    'approximate' => 'Approssimativo',
  ),
  'units' => 
  array (
    'degrees' => 'Gradi',
    'decimal_degrees' => 'Gradi decimali',
    'dms' => 'Gradi, minuti, secondi',
    'meters' => 'Metri',
    'feet' => 'Piedi',
    'nautical_miles' => 'Miglia nautiche',
  ),
  'label' => 'Coordinates',
  'plural_label' => 'Coordinates (Plurale)',
  'navigation' => 
  array (
    'name' => 'Coordinates',
    'plural' => 'Coordinates',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Coordinates',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Coordinates',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Coordinates',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Coordinates',
    ),
  ),
);
