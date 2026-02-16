<?php

declare(strict_types=1);

return array (
  'singular' => 'Indirizzo',
  'plural' => 'Indirizzi',
  'navigation' => 
  array (
    'name' => 'Indirizzo',
    'plural' => 'Indirizzi',
    'group' => 
    array (
      'name' => 'Geo',
      'description' => 'Gestione dati geografici',
    ),
    'label' => 'Indirizzo',
    'sort' => 96,
    'icon' => 'heroicon-o-map-pin',
  ),
  'actions' => 
  array (
    'create' => 'Crea indirizzo',
    'edit' => 'Modifica indirizzo',
    'view' => 'Visualizza indirizzo',
    'delete' => 'Elimina indirizzo',
    'set_primary' => 'Imposta come principale',
    'verify' => 'Verifica indirizzo',
    'geocode' => 'Geocodifica',
  ),
  'fields' => 
  array (
    'model_type' => 
    array (
      'label' => 'Tipo modello',
      'placeholder' => 'Seleziona il tipo di modello',
      'help' => 'Tipo di modello associato all\'indirizzo',
      'description' => 'Tipo del modello che possiede questo indirizzo',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'model_id' => 
    array (
      'label' => 'ID modello',
      'placeholder' => 'Inserisci ID del modello',
      'help' => 'Identificativo del modello associato',
      'description' => 'ID del modello che possiede questo indirizzo',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci un nome per l\'indirizzo',
      'help' => 'Un nome identificativo per questo indirizzo, es. "Casa" o "Ufficio"',
      'helper_text' => '',
      'description' => 'Nome identificativo dell\'indirizzo',
      'tooltip' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione',
      'help' => 'Note aggiuntive sull\'indirizzo',
      'description' => 'Descrizione aggiuntiva dell\'indirizzo',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'route' => 
    array (
      'label' => 'Via',
      'placeholder' => 'Inserisci la via',
      'help' => 'Nome della via o strada',
      'description' => 'Nome della via o strada',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'street_number' => 
    array (
      'label' => 'Numero civico',
      'placeholder' => 'Inserisci il numero civico',
      'help' => 'Numero civico dell\'edificio',
      'description' => 'Numero civico dell\'edificio',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'locality' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'help' => 'Nome della città o località',
      'description' => 'Nome della città o località',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'administrative_area_level_3' => 
    array (
      'label' => 'Comune',
      'placeholder' => 'Inserisci il comune',
      'help' => 'Comune di appartenenza',
      'description' => 'Comune di appartenenza',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'administrative_area_level_2' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Inserisci la provincia',
      'help' => 'Provincia di appartenenza',
      'description' => 'Provincia di appartenenza',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'administrative_area_level_1' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Inserisci la regione',
      'help' => 'Regione amministrativa',
      'description' => 'Regione di appartenenza',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Inserisci il paese',
      'help' => 'Paese di appartenenza',
      'description' => 'Paese di appartenenza',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'help' => 'Codice di avviamento postale',
      'description' => 'Codice di avviamento postale',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'formatted_address' => 
    array (
      'label' => 'Indirizzo formattato',
      'placeholder' => 'Indirizzo formattato completo',
      'help' => 'Indirizzo completo formattato',
      'description' => 'Indirizzo completo formattato',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'place_id' => 
    array (
      'label' => 'ID luogo',
      'placeholder' => 'ID riferimento Google Maps',
      'help' => 'Identificativo Google Maps del luogo',
      'description' => 'Identificativo Google Maps del luogo',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'latitude' => 
    array (
      'label' => 'Latitudine',
      'placeholder' => 'Inserisci la latitudine',
      'help' => 'Coordinate geografiche latitudine',
      'description' => 'Coordinate geografiche latitudine',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'longitude' => 
    array (
      'label' => 'Longitudine',
      'placeholder' => 'Inserisci la longitudine',
      'help' => 'Coordinate geografiche longitudine',
      'description' => 'Coordinate geografiche longitudine',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo di indirizzo',
      'help' => 'Tipo di indirizzo (casa, lavoro, ecc.]',
      'description' => 'Tipo di indirizzo',
      'helper_text' => '',
      'options' => 
      array (
        'billing' => 'Fatturazione',
        'shipping' => 'Spedizione',
        'home' => 'Casa',
        'work' => 'Lavoro',
        'other' => 'Altro',
      ),
      'tooltip' => '',
    ),
    'is_primary' => 
    array (
      'label' => 'Principale',
      'helper' => 'Imposta questo indirizzo come indirizzo principale',
      'description' => 'Indirizzo principale',
      'helper_text' => '',
      'placeholder' => 'Imposta come principale',
      'tooltip' => '',
    ),
    'extra_data' => 
    array (
      'label' => 'Dati aggiuntivi',
      'placeholder' => 'Inserisci dati aggiuntivi',
      'help' => 'Informazioni aggiuntive sull\'indirizzo',
      'description' => 'Dati aggiuntivi dell\'indirizzo',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'full_address' => 
    array (
      'label' => 'Indirizzo completo',
      'placeholder' => '',
      'help' => 'Indirizzo completo formattato',
      'description' => 'Indirizzo completo formattato',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'street_address' => 
    array (
      'label' => 'Indirizzo stradale',
      'placeholder' => '',
      'help' => 'Indirizzo stradale completo',
      'description' => 'Indirizzo stradale completo',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'map' => 
    array (
      'label' => 'Mappa',
      'placeholder' => '',
      'help' => 'Visualizzazione su mappa',
      'description' => 'Visualizzazione su mappa',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'cap' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'help' => 'Codice di Avviamento Postale',
      'description' => 'Codice di Avviamento Postale',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'region' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Inserisci la regione',
      'help' => 'Regione di appartenenza',
      'description' => 'Regione di appartenenza',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'province' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Inserisci la provincia',
      'help' => 'Provincia di appartenenza',
      'description' => 'Provincia di appartenenza',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'fax' => 
    array (
      'label' => 'Fax',
      'placeholder' => 'Inserisci il numero di fax',
      'help' => 'Numero di fax',
      'description' => 'Numero di fax',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'mobile' => 
    array (
      'label' => 'Cellulare',
      'placeholder' => 'Inserisci il numero di cellulare',
      'help' => 'Numero di cellulare',
      'description' => 'Numero di cellulare',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'pec' => 
    array (
      'label' => 'PEC',
      'placeholder' => 'Inserisci l\'indirizzo PEC',
      'help' => 'Posta Elettronica Certificata',
      'description' => 'Indirizzo di Posta Elettronica Certificata',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'whatsapp' => 
    array (
      'label' => 'WhatsApp',
      'placeholder' => 'Inserisci il numero WhatsApp',
      'help' => 'Numero di telefono WhatsApp',
      'description' => 'Numero di telefono WhatsApp',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'indirizzo email',
      'help' => 'Indirizzo email',
      'description' => 'Indirizzo email',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive',
      'help' => 'Note aggiuntive per l\'indirizzo',
      'description' => 'Note aggiuntive',
      'helper_text' => '',
      'tooltip' => '',
    ),
  ),
  'columns' => 
  array (
    'name' => 'Nome',
    'full_address' => 'Indirizzo completo',
    'type' => 'Tipo',
    'is_primary' => 'Principale',
    'locality' => 'Città',
    'postal_code' => 'CAP',
    'model' => 'Associato a',
  ),
  'messages' => 
  array (
    'primary_set' => 'Indirizzo impostato come principale con successo',
    'address_verified' => 'Indirizzo verificato correttamente',
    'geocoding_success' => 'Geocodifica completata con successo',
    'geocoding_failed' => 'Impossibile geocodificare l\'indirizzo',
  ),
  'sections' => 
  array (
    'location' => 
    array (
      'label' => 'Informazioni di localizzazione',
      'description' => 'Dati relativi alla posizione geografica',
    ),
    'address' => 
    array (
      'label' => 'Dati indirizzo',
      'description' => 'Dettagli dell\'indirizzo',
    ),
    'metadata' => 
    array (
      'label' => 'Metadati',
      'description' => 'Informazioni aggiuntive sull\'indirizzo',
    ),
    'map' => 
    array (
      'label' => 'Mappa',
      'description' => 'Visualizzazione su mappa',
    ),
  ),
  'steps' => 
  array (
    'Is primary' => 
    array (
      'description' => 'Is primary',
      'helper_text' => 'Is primary',
      'placeholder' => 'Is primary',
      'label' => 'Is primary',
    ),
    'Name' => 
    array (
      'label' => 'Name',
      'placeholder' => 'Name',
      'helper_text' => 'Name',
      'description' => 'Name',
    ),
    'Country' => 
    array (
      'label' => 'Country',
      'placeholder' => 'Country',
      'helper_text' => 'Country',
      'description' => 'Country',
    ),
    'Administrative area level 1' => 
    array (
      'label' => 'Administrative area level 1',
      'placeholder' => 'Administrative area level 1',
      'helper_text' => 'Administrative area level 1',
      'description' => 'Administrative area level 1',
    ),
    'Administrative area level 2' => 
    array (
      'label' => 'Administrative area level 2',
      'placeholder' => 'Administrative area level 2',
      'helper_text' => 'Administrative area level 2',
      'description' => 'Administrative area level 2',
    ),
    'Locality' => 
    array (
      'label' => 'Locality',
      'placeholder' => 'Locality',
      'helper_text' => 'Locality',
      'description' => 'Locality',
    ),
    'Postal code' => 
    array (
      'label' => 'Postal code',
      'placeholder' => 'Postal code',
      'helper_text' => 'Postal code',
      'description' => 'Postal code',
    ),
    'Route' => 
    array (
      'label' => 'Route',
      'placeholder' => 'Route',
      'helper_text' => 'Route',
      'description' => 'Route',
    ),
    'Street number' => 
    array (
      'label' => 'Street number',
      'placeholder' => 'Street number',
      'helper_text' => 'Street number',
      'description' => 'Street number',
    ),
  ),
  'toggles' => 
  array (
    'is_primary' => 
    array (
      'description' => 'is_primary',
      'helper_text' => 'is_primary',
      'label' => 'is_primary',
      'placeholder' => 'is_primary',
    ),
  ),
  'text_inputs' => 
  array (
    'name' => 
    array (
      'label' => 'name',
      'placeholder' => 'name',
      'helper_text' => 'name',
      'description' => 'name',
    ),
    'country' => 
    array (
      'label' => 'country',
      'placeholder' => 'country',
      'helper_text' => 'country',
      'description' => 'country',
    ),
    'route' => 
    array (
      'label' => 'route',
      'placeholder' => 'route',
      'helper_text' => 'route',
      'description' => 'route',
    ),
    'street_number' => 
    array (
      'label' => 'street_number',
      'placeholder' => 'street_number',
      'helper_text' => 'street_number',
      'description' => 'street_number',
    ),
  ),
  'selects' => 
  array (
    'administrative_area_level_1' => 
    array (
      'label' => 'administrative_area_level_1',
      'placeholder' => 'administrative_area_level_1',
      'helper_text' => 'administrative_area_level_1',
      'description' => 'administrative_area_level_1',
    ),
    'administrative_area_level_2' => 
    array (
      'label' => 'administrative_area_level_2',
      'placeholder' => 'administrative_area_level_2',
      'helper_text' => 'administrative_area_level_2',
      'description' => 'administrative_area_level_2',
    ),
    'locality' => 
    array (
      'label' => 'locality',
      'placeholder' => 'locality',
      'helper_text' => 'locality',
      'description' => 'locality',
    ),
    'postal_code' => 
    array (
      'label' => 'postal_code',
      'placeholder' => 'postal_code',
      'helper_text' => 'postal_code',
      'description' => 'postal_code',
    ),
  ),
  'label' => 'Address',
  'plural_label' => 'Address (Plurale)',
);
