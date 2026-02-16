<?php

declare(strict_types=1);

return [
  'navigation' => [
    'name' => 'Interfaccia',
    'plural' => 'Interfacce',
    'group' => 'Sistema',
    'label' => 'ui',
    'sort' => 70,
    'icon' => 'heroicon-o-squares-2x2',
  ],
  'label' => 'Ui',
  'plural_label' => 'Ui (Plurale)',
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
      'label' => 'Crea Ui',
    ],
    'edit' => [
      'label' => 'Modifica Ui',
    ],
    'delete' => [
      'label' => 'Elimina Ui',
    ],
  ],
];
