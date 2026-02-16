<?php

declare(strict_types=1);

return [
  'label' => 'Genere',
  'options' => [
    'f' => 'Femmina',
    'm' => 'Maschio',
  ],
  'plural_label' => 'Gender Enum (Plurale)',
  'navigation' => [
    'name' => 'Gender Enum',
    'plural' => 'Gender Enum',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Gender Enum',
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
      'label' => 'Crea Gender Enum',
    ],
    'edit' => [
      'label' => 'Modifica Gender Enum',
    ],
    'delete' => [
      'label' => 'Elimina Gender Enum',
    ],
  ],
];
