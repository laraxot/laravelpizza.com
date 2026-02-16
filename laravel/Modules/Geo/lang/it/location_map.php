<?php

declare(strict_types=1);

return [
  'navigation' => [
    'label' => 'Mappa Posizioni',
    'group' => 'Geo',
  ],
  'label' => 'Location Map',
  'plural_label' => 'Location Map (Plurale)',
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
      'label' => 'Crea Location Map',
    ],
    'edit' => [
      'label' => 'Modifica Location Map',
    ],
    'delete' => [
      'label' => 'Elimina Location Map',
    ],
  ],
];
