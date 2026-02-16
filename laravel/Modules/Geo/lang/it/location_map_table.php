<?php

declare(strict_types=1);

return [
  'navigation' => [
    'label' => 'Navigation Label',
    'group' => 'Geo',
  ],
  'label' => 'Location Map Table',
  'plural_label' => 'Location Map Table (Plurale)',
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
      'label' => 'Crea Location Map Table',
    ],
    'edit' => [
      'label' => 'Modifica Location Map Table',
    ],
    'delete' => [
      'label' => 'Elimina Location Map Table',
    ],
  ],
];
