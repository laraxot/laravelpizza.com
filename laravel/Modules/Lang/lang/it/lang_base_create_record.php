<?php

declare(strict_types=1);

return [
  'actions' => [
    'activeLocale' => [
      'label' => 'activeLocale',
    ],
  ],
  'label' => 'Lang Base Create Record',
  'plural_label' => 'Lang Base Create Record (Plurale)',
  'navigation' => [
    'name' => 'Lang Base Create Record',
    'plural' => 'Lang Base Create Record',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Lang Base Create Record',
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
