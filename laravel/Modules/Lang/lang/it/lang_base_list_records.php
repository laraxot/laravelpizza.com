<?php

declare(strict_types=1);

return [
  'actions' => [
    'activeLocale' => [
      'label' => 'activeLocale',
    ],
  ],
  'label' => 'Lang Base List Records',
  'plural_label' => 'Lang Base List Records (Plurale)',
  'navigation' => [
    'name' => 'Lang Base List Records',
    'plural' => 'Lang Base List Records',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Lang Base List Records',
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
];
