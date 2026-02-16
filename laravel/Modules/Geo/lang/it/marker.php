<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'title' => 
    array (
      'label' => 'Titolo',
      'placeholder' => 'Inserisci il titolo del marcatore',
      'help' => 'Titolo identificativo del marcatore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione',
      'help' => 'Descrizione dettagliata del marcatore',
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
    'icon' => 
    array (
      'label' => 'Icona',
      'placeholder' => 'Seleziona l\'icona',
      'help' => 'Icona da visualizzare per il marcatore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'color' => 
    array (
      'label' => 'Colore',
      'placeholder' => 'Seleziona il colore',
      'help' => 'Colore del marcatore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_draggable' => 
    array (
      'label' => 'Trascinabile',
      'help' => 'Permette di trascinare il marcatore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_clickable' => 
    array (
      'label' => 'Cliccabile',
      'help' => 'Permette di cliccare sul marcatore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'show_info_window' => 
    array (
      'label' => 'Mostra finestra info',
      'help' => 'Mostra la finestra informativa al click',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'title_required' => 'Il titolo è obbligatorio',
    'latitude_required' => 'La latitudine è obbligatoria',
    'longitude_required' => 'La longitudine è obbligatoria',
    'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
  ),
  'messages' => 
  array (
    'marker_created' => 'Marcatore creato con successo',
    'marker_updated' => 'Marcatore aggiornato con successo',
    'marker_deleted' => 'Marcatore eliminato con successo',
    'marker_moved' => 'Marcatore spostato con successo',
    'marker_icon_changed' => 'Icona del marcatore cambiata con successo',
  ),
  'icon_types' => 
  array (
    'default' => 'Predefinito',
    'home' => 'Casa',
    'work' => 'Lavoro',
    'shop' => 'Negozio',
    'restaurant' => 'Ristorante',
    'hotel' => 'Hotel',
    'hospital' => 'Ospedale',
    'school' => 'Scuola',
    'park' => 'Parco',
    'custom' => 'Personalizzato',
  ),
  'label' => 'Marker',
  'plural_label' => 'Marker (Plurale)',
  'navigation' => 
  array (
    'name' => 'Marker',
    'plural' => 'Marker',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Marker',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Marker',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Marker',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Marker',
    ),
  ),
);
