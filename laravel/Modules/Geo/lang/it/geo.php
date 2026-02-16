<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Geo',
    'group' => 'Mappe',
    'sort' => 20,
    'icon' => 'ui-geo-menu',
    'badge' => 
    array (
      'color' => 'success',
      'label' => 'Online',
    ),
  ),
  'sections' => 
  array (
    'map' => 
    array (
      'navigation' => 
      array (
        'name' => 'Mappa',
        'group' => 'Geo',
        'sort' => 10,
        'icon' => 'ui-geo-map',
        'badge' => 
        array (
          'color' => 'info',
          'label' => 'Interattiva',
        ),
      ),
      'fields' => 
      array (
        'zoom' => 'Livello Zoom',
        'center' => 'Centro Mappa',
        'type' => 'Tipo Mappa',
        'markers' => 'Marcatori',
        'bounds' => 'Confini',
      ),
      'types' => 
      array (
        'roadmap' => 'Stradale',
        'satellite' => 'Satellite',
        'hybrid' => 'Ibrida',
        'terrain' => 'Terreno',
      ),
    ),
    'location' => 
    array (
      'navigation' => 
      array (
        'name' => 'Posizioni',
        'group' => 'Geo',
        'sort' => 20,
        'icon' => 'ui-geo-location',
        'badge' => 
        array (
          'color' => 'warning',
          'label' => 'Da Verificare',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Nome',
        'address' => 'Indirizzo',
        'latitude' => 'Latitudine',
        'longitude' => 'Longitudine',
        'category' => 'Categoria',
        'status' => 'Stato',
      ),
      'categories' => 
      array (
        'business' => 'Attività',
        'residence' => 'Residenza',
        'point_of_interest' => 'Punto di Interesse',
        'public_service' => 'Servizio Pubblico',
      ),
    ),
  ),
  'common' => 
  array (
    'status' => 
    array (
      'active' => 'Attivo',
      'inactive' => 'Inattivo',
      'pending' => 'In Attesa',
      'verified' => 'Verificato',
    ),
    'actions' => 
    array (
      'locate' => 'Localizza',
      'center' => 'Centra Mappa',
      'zoom' => 'Zoom',
      'pan' => 'Sposta',
      'measure' => 'Misura',
      'directions' => 'Indicazioni',
    ),
    'messages' => 
    array (
      'success' => 
      array (
        'located' => 'Posizione trovata',
        'saved' => 'Posizione salvata',
        'updated' => 'Posizione aggiornata',
        'deleted' => 'Posizione eliminata',
      ),
      'error' => 
      array (
        'not_found' => 'Posizione non trovata',
        'invalid_coords' => 'Coordinate non valide',
        'geocoding_failed' => 'Geocodifica fallita',
        'network_error' => 'Errore di rete',
      ),
    ),
    'filters' => 
    array (
      'radius' => 'Raggio',
      'category' => 'Categoria',
      'status' => 'Stato',
      'date_range' => 'Periodo',
    ),
  ),
  'label' => 'Geo',
  'plural_label' => 'Geo (Plurale)',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Geo',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Geo',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Geo',
    ),
  ),
);
