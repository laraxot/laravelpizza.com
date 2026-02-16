<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci l\'indirizzo da geocodificare',
      'help' => 'Indirizzo completo da convertire in coordinate',
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
    'accuracy' => 
    array (
      'label' => 'Precisione',
      'placeholder' => 'Seleziona la precisione',
      'help' => 'Livello di precisione della geocodifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'provider' => 
    array (
      'label' => 'Provider',
      'placeholder' => 'Seleziona il provider',
      'help' => 'Servizio di geocodifica da utilizzare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'address_required' => 'L\'indirizzo è obbligatorio',
    'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
    'provider_required' => 'Il provider è obbligatorio',
  ),
  'messages' => 
  array (
    'geocoding_success' => 'Geocodifica completata con successo',
    'geocoding_failed' => 'Impossibile geocodificare l\'indirizzo',
    'reverse_geocoding_success' => 'Geocodifica inversa completata con successo',
    'reverse_geocoding_failed' => 'Impossibile eseguire la geocodifica inversa',
    'batch_geocoding_success' => 'Geocodifica batch completata con successo',
    'batch_geocoding_partial' => 'Geocodifica batch completata parzialmente',
    'batch_geocoding_failed' => 'Geocodifica batch fallita',
  ),
  'errors' => 
  array (
    'invalid_address' => 'Indirizzo non valido',
    'service_unavailable' => 'Servizio di geocodifica non disponibile',
    'quota_exceeded' => 'Quota di geocodifica esaurita',
    'rate_limit_exceeded' => 'Limite di richieste superato',
    'invalid_coordinates' => 'Coordinate geografiche non valide',
    'no_results_found' => 'Nessun risultato trovato',
  ),
  'label' => 'Geocoding',
  'plural_label' => 'Geocoding (Plurale)',
  'navigation' => 
  array (
    'name' => 'Geocoding',
    'plural' => 'Geocoding',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Geocoding',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Geocoding',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Geocoding',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Geocoding',
    ),
  ),
);
