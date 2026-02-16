<?php

declare(strict_types=1);

return array (
  'singular' => 'Address',
  'plural' => 'Addresses',
  'navigation' => 
  array (
    'sort' => 96,
    'icon' => 'heroicon-o-map-pin',
    'group' => 'Geo',
    'label' => 'Address',
  ),
  'actions' => 
  array (
    'create' => 'Create Address',
    'edit' => 'Edit Address',
    'view' => 'View Address',
    'delete' => 'Delete Address',
    'set_primary' => 'Set as Primary',
    'verify' => 'Verify Address',
    'geocode' => 'Geocode',
  ),
  'fields' => 
  array (
    'model_type' => 
    array (
      'label' => 'Model Type',
      'placeholder' => 'Select model type',
      'help' => 'Model type associated with the address',
      'description' => 'Type of model that owns this address',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'model_id' => 
    array (
      'label' => 'Model ID',
      'placeholder' => 'Enter model ID',
      'help' => 'Identifier of the associated model',
      'description' => 'ID of the model that owns this address',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'name' => 
    array (
      'label' => 'Name',
      'placeholder' => 'Enter a name for the address',
      'help' => 'An identifying name for this address, e.g. "Home" or "Office"',
      'helper_text' => '',
      'description' => 'Address identifying name',
      'tooltip' => '',
    ),
    'description' => 
    array (
      'label' => 'Description',
      'placeholder' => 'Enter a description',
      'help' => 'Additional notes about the address',
      'description' => 'Additional address description',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'street' => 
    array (
      'label' => 'Street',
      'placeholder' => 'Enter street address',
      'help' => 'Street address including number',
      'description' => 'Street address',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Enter city',
      'help' => 'City name',
      'description' => 'City name',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'state' => 
    array (
      'label' => 'State/Province',
      'placeholder' => 'Enter state or province',
      'help' => 'State or province name',
      'description' => 'State or province',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'Postal Code',
      'placeholder' => 'Enter postal code',
      'help' => 'ZIP or postal code',
      'description' => 'Postal code',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'country' => 
    array (
      'label' => 'Country',
      'placeholder' => 'Enter country',
      'help' => 'Country name',
      'description' => 'Country name',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'latitude' => 
    array (
      'label' => 'Latitude',
      'placeholder' => 'Enter latitude',
      'help' => 'Geographic latitude coordinate',
      'description' => 'Latitude coordinate',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'longitude' => 
    array (
      'label' => 'Longitude',
      'placeholder' => 'Enter longitude',
      'help' => 'Geographic longitude coordinate',
      'description' => 'Longitude coordinate',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'is_primary' => 
    array (
      'label' => 'Primary Address',
      'help' => 'Mark as primary address',
      'description' => 'Whether this is the primary address',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'is_verified' => 
    array (
      'label' => 'Verified Address',
      'help' => 'Address has been verified',
      'description' => 'Whether this address has been verified',
      'helper_text' => '',
      'tooltip' => '',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
