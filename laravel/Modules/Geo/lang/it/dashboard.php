<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Dashboard Geo',
    'plural' => 'Dashboard Geo',
    'group' => 
    array (
      'name' => 'Geo',
      'description' => 'Panoramica delle informazioni geografiche',
    ),
    'label' => 'Dashboard',
    'sort' => 30,
    'icon' => 'ui-dashboard',
  ),
  'widgets' => 
  array (
    'total_locations' => 'Totale Località',
    'total_places' => 'Totale Luoghi',
    'recent_activity' => 'Attività Recente',
    'popular_places' => 'Luoghi Popolari',
  ),
  'charts' => 
  array (
    'locations_by_type' => 'Località per Tipo',
    'places_by_category' => 'Luoghi per Categoria',
    'activity_timeline' => 'Timeline Attività',
  ),
  'label' => 'Dashboard',
  'plural_label' => 'Dashboard (Plurale)',
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
      'label' => 'Crea Dashboard',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Dashboard',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Dashboard',
    ),
  ),
);
