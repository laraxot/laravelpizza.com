<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome percorso',
      'placeholder' => 'Inserisci il nome del percorso',
      'help' => 'Nome identificativo del percorso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione',
      'help' => 'Descrizione dettagliata del percorso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'start_point' => 
    array (
      'label' => 'Punto di partenza',
      'placeholder' => 'Seleziona il punto di partenza',
      'help' => 'Punto di inizio del percorso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'end_point' => 
    array (
      'label' => 'Punto di arrivo',
      'placeholder' => 'Seleziona il punto di arrivo',
      'help' => 'Punto di destinazione del percorso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'waypoints' => 
    array (
      'label' => 'Punti intermedi',
      'placeholder' => 'Aggiungi punti intermedi',
      'help' => 'Punti intermedi del percorso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'transport_mode' => 
    array (
      'label' => 'Modalità di trasporto',
      'placeholder' => 'Seleziona la modalità',
      'help' => 'Mezzo di trasporto per il percorso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'avoid_tolls' => 
    array (
      'label' => 'Evita pedaggi',
      'help' => 'Evita strade a pedaggio',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'avoid_highways' => 
    array (
      'label' => 'Evita autostrade',
      'help' => 'Evita le autostrade',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'optimize_waypoints' => 
    array (
      'label' => 'Ottimizza punti intermedi',
      'help' => 'Ottimizza l\'ordine dei punti intermedi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'name_required' => 'Il nome del percorso è obbligatorio',
    'start_point_required' => 'Il punto di partenza è obbligatorio',
    'end_point_required' => 'Il punto di arrivo è obbligatorio',
    'transport_mode_required' => 'La modalità di trasporto è obbligatoria',
  ),
  'messages' => 
  array (
    'route_created' => 'Percorso creato con successo',
    'route_updated' => 'Percorso aggiornato con successo',
    'route_deleted' => 'Percorso eliminato con successo',
    'route_calculated' => 'Percorso calcolato con successo',
    'route_calculation_failed' => 'Impossibile calcolare il percorso',
    'waypoint_added' => 'Punto intermedio aggiunto con successo',
    'waypoint_removed' => 'Punto intermedio rimosso con successo',
  ),
  'transport_modes' => 
  array (
    'driving' => 'Auto',
    'walking' => 'A piedi',
    'bicycling' => 'Bicicletta',
    'transit' => 'Trasporto pubblico',
    'flying' => 'Aereo',
  ),
  'route_info' => 
  array (
    'distance' => 'Distanza',
    'duration' => 'Durata',
    'duration_traffic' => 'Durata con traffico',
    'toll_roads' => 'Strade a pedaggio',
    'highways' => 'Autostrade',
    'ferries' => 'Traghetti',
    'indoor' => 'Indoor',
  ),
  'label' => 'Route',
  'plural_label' => 'Route (Plurale)',
  'navigation' => 
  array (
    'name' => 'Route',
    'plural' => 'Route',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Route',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Route',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Route',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Route',
    ),
  ),
);
