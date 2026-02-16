<?php

declare(strict_types=1);

return [
  'fields' => [
    'new_password_confirmation' => [
      'label' => 'Conferma nuova password',
      'description' => 'Digita nuovamente la nuova password per conferma',
      'helper_text' => '',
      'placeholder' => 'Reinserisci la nuova password',
    ],
    'changePassword' => [
      'label' => 'Cambia password',
    ],
  ],
  'navigation' => [
    'name' => 'Change Password',
    'plural' => 'Change Password',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Change Password',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Change Password',
  'plural_label' => 'Change Password (Plurale)',
  'actions' => [
    'cancel' => [
      'tooltip' => 'cancel',
    ],
  ],
];
