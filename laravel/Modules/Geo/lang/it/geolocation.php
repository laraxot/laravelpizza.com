<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'ip_address' => 
    array (
      'label' => 'Indirizzo IP',
      'placeholder' => 'Inserisci l\'indirizzo IP',
      'help' => 'Indirizzo IP da geolocalizzare',
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
      'help' => 'Livello di precisione della geolocalizzazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'provider' => 
    array (
      'label' => 'Provider',
      'placeholder' => 'Seleziona il provider',
      'help' => 'Servizio di geolocalizzazione da utilizzare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Seleziona il paese',
      'help' => 'Paese rilevato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'region' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Seleziona la regione',
      'help' => 'Regione rilevata',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Seleziona la città',
      'help' => 'Città rilevata',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timezone' => 
    array (
      'label' => 'Fuso orario',
      'placeholder' => 'Seleziona il fuso orario',
      'help' => 'Fuso orario rilevato',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'ip_address_required' => 'L\'indirizzo IP è obbligatorio',
    'ip_address_invalid' => 'L\'indirizzo IP non è valido',
    'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
    'provider_required' => 'Il provider è obbligatorio',
  ),
  'messages' => 
  array (
    'geolocation_success' => 'Geolocalizzazione completata con successo',
    'geolocation_failed' => 'Impossibile geolocalizzare l\'indirizzo IP',
    'batch_geolocation_success' => 'Geolocalizzazione batch completata con successo',
    'batch_geolocation_partial' => 'Geolocalizzazione batch completata parzialmente',
    'batch_geolocation_failed' => 'Geolocalizzazione batch fallita',
    'ip_updated' => 'Indirizzo IP aggiornato con successo',
    'location_updated' => 'Posizione aggiornata con successo',
  ),
  'errors' => 
  array (
    'invalid_ip' => 'Indirizzo IP non valido',
    'service_unavailable' => 'Servizio di geolocalizzazione non disponibile',
    'quota_exceeded' => 'Quota di geolocalizzazione esaurita',
    'rate_limit_exceeded' => 'Limite di richieste superato',
    'no_results_found' => 'Nessun risultato trovato',
    'private_ip' => 'Indirizzo IP privato non geolocalizzabile',
    'reserved_ip' => 'Indirizzo IP riservato non geolocalizzabile',
  ),
  'accuracy_levels' => 
  array (
    'country' => 'Paese',
    'region' => 'Regione',
    'city' => 'Città',
    'district' => 'Distretto',
    'street' => 'Via',
    'building' => 'Edificio',
  ),
  'label' => 'Geolocation',
  'plural_label' => 'Geolocation (Plurale)',
  'navigation' => 
  array (
    'name' => 'Geolocation',
    'plural' => 'Geolocation',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Geolocation',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Geolocation',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Geolocation',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Geolocation',
    ),
  ),
);
