<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Locations',
    'plural' => 'Locations',
    'group' => 
    array (
      'name' => 'Geo',
      'description' => 'Manage locations and geographic positions',
    ),
    'label' => 'Locations',
    'sort' => '94',
    'icon' => 'ui-geo-location',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Address',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Select a city',
      'help' => 'Select or enter the city name',
      'tooltip' => 'City name',
      'description' => 'City of the address',
      'icon' => 'heroicon-o-building-office',
      'color' => 'primary',
      'helper_text' => '',
    ),
    'province' => 
    array (
      'label' => 'Province',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'Postal Code',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'country' => 
    array (
      'label' => 'Country',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'latitude' => 
    array (
      'label' => 'Latitude',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'longitude' => 
    array (
      'label' => 'Longitude',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'Type',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'types' => 
  array (
    'business' => 'Business',
    'residence' => 'Residence',
    'point_of_interest' => 'Point of Interest',
    'landmark' => 'Landmark',
  ),
  'actions' => 
  array (
    'view_map' => 'View Map',
    'get_directions' => 'Get Directions',
    'copy_coordinates' => 'Copy Coordinates',
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
