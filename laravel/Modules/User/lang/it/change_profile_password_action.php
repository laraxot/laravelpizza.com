<?php

declare(strict_types=1);

return [
  'fields' => [
    'new_password_confirmation' => [
      'label' => 'Conferma nuova password',
      'placeholder' => 'Reinserisci la nuova password',
      'helper_text' => '',
      'description' => 'Digita nuovamente la nuova password per conferma',
      'tooltip' => 'Ripeti la nuova password per sicurezza',
      'icon' => 'heroicon-o-lock-closed',
      'color' => 'warning',
    ],
  ],
  'navigation' => [
    'name' => 'Change Profile Password Action',
    'plural' => 'Change Profile Password Action',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Change Profile Password Action',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Change Profile Password Action',
  'plural_label' => 'Change Profile Password Action (Plurale)',
  'actions' => [
    'create' => [
      'label' => 'Crea Change Profile Password Action',
    ],
    'edit' => [
      'label' => 'Modifica Change Profile Password Action',
    ],
    'delete' => [
      'label' => 'Elimina Change Profile Password Action',
    ],
  ],
];
