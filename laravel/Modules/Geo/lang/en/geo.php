<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'icons' => 
    array (
      'location-map' => 
      array (
        'default' => 'heroicon-o-map-pin',
        'hover' => 'heroicon-o-map-pin animate-bounce',
        'title' => 'Location icon',
      ),
      'lat-lng' => 
      array (
        'default' => 'heroicon-o-map-pin',
        'hover' => 'heroicon-o-map-pin animate-pulse',
        'title' => 'Coordinates icon',
      ),
      'webbingbrasil-map' => 
      array (
        'default' => 'heroicon-o-map',
        'hover' => 'heroicon-o-map animate-spin',
        'title' => 'Webbingbrasil map icon',
      ),
      'osm-map' => 
      array (
        'default' => 'heroicon-o-globe-alt',
        'hover' => 'heroicon-o-globe-alt animate-spin',
        'title' => 'Global map icon',
      ),
      'dotswan-map' => 
      array (
        'default' => 'heroicon-o-map',
        'hover' => 'heroicon-o-map animate-spin',
        'title' => 'Dotswan map icon',
      ),
      'setting-page' => 
      array (
        'default' => 'heroicon-o-cog-6-tooth',
        'hover' => 'heroicon-o-cog-6-tooth animate-spin',
        'title' => 'Settings icon',
      ),
    ),
    'groups' => 
    array (
      'geo' => 
      array (
        'name' => 'Geo',
        'description' => 'Maps and location management',
      ),
    ),
    'pages' => 
    array (
      'location-map' => 
      array (
        'label' => 'Location Map',
        'description' => 'View and manage locations on the map',
        'sort' => '1',
      ),
      'lat-lng' => 
      array (
        'label' => 'Coordinates',
        'description' => 'Geographic coordinates management',
        'sort' => '2',
      ),
      'webbingbrasil-map' => 
      array (
        'label' => 'Webbingbrasil Map',
        'description' => 'Map view with Webbingbrasil',
        'sort' => '3',
      ),
      'osm-map' => 
      array (
        'label' => 'OSM Map',
        'description' => 'OpenStreetMap view',
        'sort' => '4',
      ),
      'dotswan-map' => 
      array (
        'label' => 'Dotswan Map',
        'description' => 'Map view with Dotswan',
        'sort' => '5',
      ),
      'setting-page' => 
      array (
        'label' => 'Settings',
        'description' => 'Geo module configuration',
        'sort' => '6',
      ),
    ),
    'name' => 'Geo',
    'group' => 'Mappe',
    'sort' => '20',
    'icon' => 'ui-geo-menu',
    'badge' => 
    array (
      'color' => 'success',
      'label' => 'Online',
    ),
  ),
  'status' => 
  array (
    'waiting' => 'Waiting...',
    'loading' => 'Loading...',
    'error' => 'Error',
    'success' => 'Completed',
  ),
  'actions' => 
  array (
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'edit' => 'Edit',
    'view' => 'View',
  ),
  'messages' => 
  array (
    'saved' => 'Successfully saved',
    'deleted' => 'Successfully deleted',
    'error' => 'An error occurred',
  ),
  'sections' => 
  array (
    'map' => 
    array (
      'navigation' => 
      array (
        'name' => 'Mappa',
        'group' => 'Geo',
        'sort' => '10',
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
        'sort' => '20',
        'icon' => 'ui-geo-location',
        'badge' => 
        array (
          'color' => 'warning',
          'label' => 'Da Verificare',
        ),
      ),
      'fields' => 
      array (
        'name' => 'Name',
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
        'public_service' => 'Servizio Public',
      ),
    ),
  ),
  'common' => 
  array (
    'status' => 
    array (
      'active' => 'Active',
      'inactive' => 'Inactive',
      'pending' => 'In Attesa',
      'verified' => 'Verified',
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
        'located' => 'Location found',
        'saved' => 'Location saved',
        'updated' => 'Location updated',
        'deleted' => 'Location deleted',
      ),
      'error' => 
      array (
        'not_found' => 'Location not found',
        'invalid_coords' => 'Invalid coordinates',
        'geocoding_failed' => 'Geocoding failed',
        'network_error' => 'Network error',
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
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
);
