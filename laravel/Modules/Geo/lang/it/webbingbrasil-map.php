<?php

declare(strict_types=1);

return [
  'navigation' => [
    'label' => 'Mappa Webbingbrasil',
    'group' => 'Gestione Territorio',
    'icon' => 'heroicon-o-map',
    'sort' => 60,
  ],
  'controls' => [
    'zoom' => [
      'in' => 'Aumenta zoom',
      'out' => 'Diminuisci zoom',
    ],
    'fullscreen' => 'Schermo intero',
    'layers' => 'Cambia layer',
  ],
  'markers' => [
    'add' => 'Aggiungi marker',
    'remove' => 'Rimuovi marker',
    'edit' => 'Modifica marker',
  ],
  'messages' => [
    'marker_added' => 'Marker aggiunto con successo',
    'marker_removed' => 'Marker rimosso con successo',
    'marker_updated' => 'Marker aggiornato con successo',
  ],
  'label' => 'Webbingbrasil Map',
  'plural_label' => 'Webbingbrasil Map (Plurale)',
  'fields' => [
    'id' => [
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
    ],
    'created_at' => [
      'label' => 'Data Creazione',
    ],
    'updated_at' => [
      'label' => 'Ultima Modifica',
    ],
  ],
  'actions' => [
    'create' => [
      'label' => 'Crea Webbingbrasil Map',
    ],
    'edit' => [
      'label' => 'Modifica Webbingbrasil Map',
    ],
    'delete' => [
      'label' => 'Elimina Webbingbrasil Map',
    ],
  ],
];
