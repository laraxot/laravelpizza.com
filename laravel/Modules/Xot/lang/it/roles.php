<?php

declare(strict_types=1);

return [
  'administrator' => 'Amministratore',
  'user' => 'Utente',
  'label' => 'Roles',
  'plural_label' => 'Roles (Plurale)',
  'navigation' => [
    'name' => 'Roles',
    'plural' => 'Roles',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Roles',
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
      'label' => 'Crea Roles',
    ],
    'edit' => [
      'label' => 'Modifica Roles',
    ],
    'delete' => [
      'label' => 'Elimina Roles',
    ],
  ],
];
