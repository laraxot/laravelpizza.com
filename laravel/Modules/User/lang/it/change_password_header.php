<?php

declare(strict_types=1);

return [
  'fields' => [
    'new_password_confirmation' => [
      'label' => 'Conferma nuova password',
      'placeholder' => 'Conferma la tua nuova password',
      'helper_text' => '',
      'description' => 'Inserisci nuovamente la nuova password per confermarla',
      'tooltip' => 'Ripeti la nuova password per sicurezza',
      'icon' => 'heroicon-o-lock-closed',
      'color' => 'warning',
    ],
  ],
  'navigation' => [
    'name' => 'Change Password Header',
    'plural' => 'Change Password Header',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Change Password Header',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Change Password Header',
  'plural_label' => 'Change Password Header (Plurale)',
  'actions' => [
    'create' => [
      'label' => 'Crea Change Password Header',
    ],
    'edit' => [
      'label' => 'Modifica Change Password Header',
    ],
    'delete' => [
      'label' => 'Elimina Change Password Header',
    ],
  ],
];
