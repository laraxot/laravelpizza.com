<?php

declare(strict_types=1);

return [
  'id' => 'id',
  'level' => 'level',
  'name' => 'name',
  'color' => 'color',
  'created_by' => 'created_by',
  'updated_by' => 'updated_by',
  'deleted_by' => 'deleted_by',
  'created_at' => 'created_at',
  'updated_at' => 'updated_at',
  'deleted_at' => 'deleted_at',
  'label' => 'Xls By Model Class Action',
  'plural_label' => 'Xls By Model Class Action (Plurale)',
  'navigation' => [
    'name' => 'Xls By Model Class Action',
    'plural' => 'Xls By Model Class Action',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Xls By Model Class Action',
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
      'label' => 'Crea Xls By Model Class Action',
    ],
    'edit' => [
      'label' => 'Modifica Xls By Model Class Action',
    ],
    'delete' => [
      'label' => 'Elimina Xls By Model Class Action',
    ],
  ],
];
