<?php

declare(strict_types=1);

return [
  'navigation' => [
    'label' => 'temporary upload',
    'group' => 'temporary upload',
    'icon' => 'temporary upload',
    'sort' => 96,
  ],
  'label' => 'Temporary Upload',
  'plural_label' => 'Temporary Upload (Plurale)',
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
      'label' => 'Crea Temporary Upload',
    ],
    'edit' => [
      'label' => 'Modifica Temporary Upload',
    ],
    'delete' => [
      'label' => 'Elimina Temporary Upload',
    ],
  ],
];
