<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Impostazioni Geo',
    'plural' => 'Impostazioni Geo',
    'group' => 
    array (
      'name' => 'Geo',
      'description' => 'Configurazione del modulo geografico',
    ),
    'label' => 'Impostazioni',
    'sort' => '34',
    'icon' => 'ui-settings',
  ),
  'fields' => 
  array (
    'default_map_provider' => 
    array (
      'label' => 'Provider Mappa Predefinito',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'api_keys' => 
    array (
      'google_maps' => 'API Key Google Maps',
      'mapbox' => 'API Key Mapbox',
      'here' => 'API Key HERE Maps',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'default_location' => 
    array (
      'lat' => 'Latitudine Predefinita',
      'lng' => 'Longitudine Predefinita',
      'zoom' => 'Zoom Predefinito',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'display_options' => 
    array (
      'units' => 'Unità di Misura',
      'language' => 'Lingua Mappe',
      'theme' => 'Tema Mappe',
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'providers' => 
  array (
    'google' => 'Google Maps',
    'mapbox' => 'Mapbox',
    'here' => 'HERE Maps',
    'osm' => 'OpenStreetMap',
  ),
  'units' => 
  array (
    'metric' => 'Metrico',
    'imperial' => 'Imperiale',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'actions' => 
  array (
  ),
);
