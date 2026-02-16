<?php

declare(strict_types=1);

return [
  'list_log_activities' => [
    'label' => 'Cronologia',
    'tooltip' => 'Visualizza storico modifiche',
    'icon' => 'heroicon-o-clock',
    'color' => 'gray',
    'modal' => [
      'heading' => 'Storico Modifiche',
      'description' => 'Visualizza tutte le modifiche effettuate su questo record',
    ],
    'view_all' => 'Visualizza Tutto',
    'close' => 'Chiudi',
    'messages' => [
      'no_activities' => 'Nessuna modifica registrata per questo record',
      'loading' => 'Caricamento storico in corso...',
    ],
  ],
  'label' => 'Actions',
  'plural_label' => 'Actions (Plurale)',
  'navigation' => [
    'name' => 'Actions',
    'plural' => 'Actions',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Actions',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
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
      'label' => 'Crea Actions',
    ],
    'edit' => [
      'label' => 'Modifica Actions',
    ],
    'delete' => [
      'label' => 'Elimina Actions',
    ],
  ],
];
