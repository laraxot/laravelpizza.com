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
    'name' => 'Change Profile Password',
    'plural' => 'Change Profile Password',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Change Profile Password',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Change Profile Password',
  'plural_label' => 'Change Profile Password (Plurale)',
  'actions' => [
    'create' => [
      'label' => 'Crea Change Profile Password',
    ],
    'edit' => [
      'label' => 'Modifica Change Profile Password',
    ],
    'delete' => [
      'label' => 'Elimina Change Profile Password',
    ],
  ],
];
