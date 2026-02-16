<?php

declare(strict_types=1);

return [
  'label' => 'Sì/No',
  'options' => [
    'yes' => 'Sì',
    'no' => 'No',
  ],
  'plural_label' => 'Yes No Enum (Plurale)',
  'navigation' => [
    'name' => 'Yes No Enum',
    'plural' => 'Yes No Enum',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Yes No Enum',
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
      'label' => 'Crea Yes No Enum',
    ],
    'edit' => [
      'label' => 'Modifica Yes No Enum',
    ],
    'delete' => [
      'label' => 'Elimina Yes No Enum',
    ],
  ],
];
