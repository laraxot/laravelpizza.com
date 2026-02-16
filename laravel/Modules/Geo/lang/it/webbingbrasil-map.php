<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Mappa Webbingbrasil',
    'group' => 'Gestione Territorio',
    'icon' => 'heroicon-o-map',
    'sort' => 60,
  ),
  'controls' => 
  array (
    'zoom' => 
    array (
      'in' => 'Aumenta zoom',
      'out' => 'Diminuisci zoom',
    ),
    'fullscreen' => 'Schermo intero',
    'layers' => 'Cambia layer',
  ),
  'markers' => 
  array (
    'add' => 'Aggiungi marker',
    'remove' => 'Rimuovi marker',
    'edit' => 'Modifica marker',
  ),
  'messages' => 
  array (
    'marker_added' => 'Marker aggiunto con successo',
    'marker_removed' => 'Marker rimosso con successo',
    'marker_updated' => 'Marker aggiornato con successo',
  ),
  'label' => 'Webbingbrasil Map',
  'plural_label' => 'Webbingbrasil Map (Plurale)',
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
      'label' => 'Crea Webbingbrasil Map',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Webbingbrasil Map',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Webbingbrasil Map',
    ),
  ),
);
