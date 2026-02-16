<?php

declare(strict_types=1);

return [
  'id' => 'id',
  'tipo' => 'tipo',
  'codice' => 'codice',
  'descr' => 'descr',
  'anno' => 'anno',
  'created_at' => 'created_at',
  'created_by' => 'created_by',
  'updated_at' => 'updated_at',
  'updated_by' => 'updated_by',
  'deleted_at' => 'deleted_at',
  'deleted_by' => 'deleted_by',
  'label' => 'Xls Action',
  'plural_label' => 'Xls Action (Plurale)',
  'navigation' => [
    'name' => 'Xls Action',
    'plural' => 'Xls Action',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Xls Action',
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
      'label' => 'Crea Xls Action',
    ],
    'edit' => [
      'label' => 'Modifica Xls Action',
    ],
    'delete' => [
      'label' => 'Elimina Xls Action',
    ],
  ],
];
