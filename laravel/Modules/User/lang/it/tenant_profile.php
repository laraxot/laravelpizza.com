<?php

declare(strict_types=1);

return [
  'actions' => [
    'save' => [
      'label' => 'save',
      'icon' => 'save',
      'tooltip' => 'save',
    ],
    'profile' => [
      'label' => 'profile',
      'icon' => 'profile',
      'tooltip' => 'profile',
    ],
    'billing' => [
      'label' => 'billing',
      'icon' => 'billing',
      'tooltip' => 'billing',
    ],
    'register' => [
      'label' => 'register',
      'icon' => 'register',
      'tooltip' => 'register',
    ],
    'logout' => [
      'label' => 'logout',
      'icon' => 'logout',
      'tooltip' => 'logout',
    ],
  ],
  'navigation' => [
    'name' => 'Tenant Profile',
    'plural' => 'Tenant Profile',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Tenant Profile',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Tenant Profile',
  'plural_label' => 'Tenant Profile (Plurale)',
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
