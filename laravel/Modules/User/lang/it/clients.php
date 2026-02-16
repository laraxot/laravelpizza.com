<?php

declare(strict_types=1);

return [
  'fields' => [
    'name' => [
      'label' => 'name',
    ],
  ],
  'navigation' => [
    'name' => 'Clients',
    'plural' => 'Clients',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Clients',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Clients',
  'plural_label' => 'Clients (Plurale)',
  'actions' => [
    'create' => [
      'label' => 'Crea Clients',
    ],
    'edit' => [
      'label' => 'Modifica Clients',
    ],
    'delete' => [
      'label' => 'Elimina Clients',
    ],
  ],
];
