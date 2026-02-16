<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'data' => 
    array (
      'label' => 'Dati',
      'placeholder' => 'Inserisci i dati da validare',
      'help' => 'Dati da sottoporre a validazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'rules' => 
    array (
      'label' => 'Regole',
      'placeholder' => 'Configura le regole di validazione',
      'help' => 'Regole di validazione da applicare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'custom_messages' => 
    array (
      'label' => 'Messaggi personalizzati',
      'placeholder' => 'Configura i messaggi di errore personalizzati',
      'help' => 'Messaggi di errore personalizzati per le regole',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'custom_attributes' => 
    array (
      'label' => 'Attributi personalizzati',
      'placeholder' => 'Configura i nomi degli attributi personalizzati',
      'help' => 'Nomi personalizzati per gli attributi nei messaggi di errore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'bail' => 
    array (
      'label' => 'Interrompi al primo errore',
      'help' => 'Interrompi la validazione al primo errore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'stop_on_first_failure' => 
    array (
      'label' => 'Ferma al primo fallimento',
      'help' => 'Ferma la validazione al primo fallimento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'data_required' => 'I dati sono obbligatori',
    'rules_required' => 'Le regole sono obbligatorie',
    'rules_invalid' => 'Le regole non sono valide',
    'custom_messages_invalid' => 'I messaggi personalizzati non sono validi',
    'custom_attributes_invalid' => 'Gli attributi personalizzati non sono validi',
  ),
  'messages' => 
  array (
    'validation_started' => 'Validazione avviata con successo',
    'validation_completed' => 'Validazione completata con successo',
    'validation_failed' => 'Validazione fallita',
    'data_valid' => 'I dati sono validi',
    'data_invalid' => 'I dati non sono validi',
    'errors_found' => ':count errori trovati',
    'no_errors' => 'Nessun errore trovato',
    'warnings_found' => ':count avvisi trovati',
    'no_warnings' => 'Nessun avviso trovato',
  ),
  'errors' => 
  array (
    'data_empty' => 'I dati sono vuoti',
    'rules_empty' => 'Le regole sono vuote',
    'rules_syntax_error' => 'Errore di sintassi nelle regole',
    'custom_messages_syntax_error' => 'Errore di sintassi nei messaggi personalizzati',
    'custom_attributes_syntax_error' => 'Errore di sintassi negli attributi personalizzati',
    'validation_timeout' => 'Timeout della validazione',
    'memory_limit_exceeded' => 'Limite di memoria superato',
  ),
  'common_rules' => 
  array (
    'required' => 'Obbligatorio',
    'string' => 'Stringa',
    'numeric' => 'Numerico',
    'integer' => 'Intero',
    'decimal' => 'Decimale',
    'boolean' => 'Booleano',
    'email' => 'Email',
    'url' => 'URL',
    'date' => 'Data',
    'date_format' => 'Formato data',
    'before' => 'Prima di',
    'after' => 'Dopo di',
    'between' => 'Tra',
    'min' => 'Minimo',
    'max' => 'Massimo',
    'size' => 'Dimensione',
    'unique' => 'Unico',
    'exists' => 'Esiste',
    'confirmed' => 'Confermato',
    'different' => 'Diverso',
    'same' => 'Stesso',
    'regex' => 'Espressione regolare',
    'alpha' => 'Alfabetico',
    'alpha_num' => 'Alfanumerico',
    'alpha_dash' => 'Alfanumerico con trattini',
    'alpha_spaces' => 'Alfabetico con spazi',
    'numeric_spaces' => 'Numerico con spazi',
    'alpha_numeric_spaces' => 'Alfanumerico con spazi',
  ),
  'geo_specific_rules' => 
  array (
    'coordinates' => 'Coordinate valide',
    'latitude' => 'Latitudine valida',
    'longitude' => 'Longitudine valida',
    'postal_code' => 'CAP valido',
    'phone_code' => 'Prefisso telefonico valido',
    'country_code' => 'Codice paese valido',
    'timezone' => 'Fuso orario valido',
    'geometry' => 'Geometria valida',
    'geojson' => 'GeoJSON valido',
    'shapefile' => 'Shapefile valido',
    'kml' => 'KML valido',
    'gpx' => 'GPX valido',
  ),
  'validation_results' => 
  array (
    'passed' => 'Validazione superata',
    'failed' => 'Validazione fallita',
    'partial' => 'Validazione parziale',
    'skipped' => 'Validazione saltata',
    'pending' => 'Validazione in attesa',
  ),
  'label' => 'Validation',
  'plural_label' => 'Validation (Plurale)',
  'navigation' => 
  array (
    'name' => 'Validation',
    'plural' => 'Validation',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Validation',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Validation',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Validation',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Validation',
    ),
  ),
);
