<?php

declare(strict_types=1);

return [
  'update_coordinates' => [
    'errors' => [
      'empty_address' => 'Indirizzo vuoto non può essere geocodato',
      'geocoding_failed' => 'Impossibile ottenere le coordinate dall\'indirizzo',
    ],
    'bulk' => [
      'label' => 'Aggiorna coordinate',
      'errors' => [
        'generic' => 'Errore durante l\'aggiornamento delle coordinate',
        'record' => 'Errore per :name: :error',
      ],
      'notifications' => [
        'success' => [
          'title' => 'Coordinate aggiornate',
          'body' => 'Aggiornate le coordinate di :count record su :total',
        ],
        'warning' => [
          'title' => 'Alcuni aggiornamenti non sono riusciti',
          'more_errors' => '... e altri :count errori',
        ],
      ],
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
