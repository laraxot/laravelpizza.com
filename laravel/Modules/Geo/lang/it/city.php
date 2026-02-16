<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome città',
      'placeholder' => 'Inserisci il nome della città',
      'help' => 'Nome ufficiale della città',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'province' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Seleziona la provincia',
      'help' => 'Provincia di appartenenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'region' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Seleziona la regione',
      'help' => 'Regione di appartenenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Seleziona il paese',
      'help' => 'Paese di appartenenza',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'help' => 'Codice di avviamento postale',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
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
    'population' => 
    array (
      'label' => 'Popolazione',
      'placeholder' => 'Inserisci il numero di abitanti',
      'help' => 'Numero di abitanti della città',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'area' => 
    array (
      'label' => 'Superficie',
      'placeholder' => 'Inserisci la superficie in km²',
      'help' => 'Superficie della città in chilometri quadrati',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome della città è obbligatorio',
    'province_required' => 'La provincia è obbligatoria',
    'region_required' => 'La regione è obbligatoria',
    'country_required' => 'Il paese è obbligatorio',
    'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
  ),
  'messages' => 
  array (
    'city_created' => 'Città creata con successo',
    'city_updated' => 'Città aggiornata con successo',
    'city_deleted' => 'Città eliminata con successo',
    'geocoding_success' => 'Geocoding completato con successo',
    'geocoding_error' => 'Errore durante il geocoding',
  ),
  'label' => 'City',
  'plural_label' => 'City (Plurale)',
  'navigation' => 
  array (
    'name' => 'City',
    'plural' => 'City',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'City',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea City',
    ),
    'edit' => 
    array (
      'label' => 'Modifica City',
    ),
    'delete' => 
    array (
      'label' => 'Elimina City',
    ),
  ),
);
