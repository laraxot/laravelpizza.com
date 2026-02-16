<?php

declare(strict_types=1);

return [
  'name' => 'name',
  'value' => 'value',
  'label' => 'Update Job',
  'plural_label' => 'Update Job (Plurale)',
  'navigation' => [
    'name' => 'Update Job',
    'plural' => 'Update Job',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Update Job',
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
      'label' => 'Crea Update Job',
    ],
    'edit' => [
      'label' => 'Modifica Update Job',
    ],
    'delete' => [
      'label' => 'Elimina Update Job',
    ],
  ],
];
