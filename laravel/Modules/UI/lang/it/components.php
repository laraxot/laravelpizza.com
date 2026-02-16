<?php

declare(strict_types=1);

return [
  'state_icons' => [
    'no_transitions' => 'Nessuna transizione disponibile',
  ],
  'label' => 'Components',
  'plural_label' => 'Components (Plurale)',
  'navigation' => [
    'name' => 'Components',
    'plural' => 'Components',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Components',
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
      'label' => 'Crea Components',
    ],
    'edit' => [
      'label' => 'Modifica Components',
    ],
    'delete' => [
      'label' => 'Elimina Components',
    ],
  ],
];
