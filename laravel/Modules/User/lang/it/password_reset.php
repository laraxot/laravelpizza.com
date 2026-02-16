<?php

declare(strict_types=1);

return [
  'navigation' => [
    'name' => 'Reset Password',
    'plural' => 'Reset Password',
    'label' => 'Reset Password',
    'group' => [
      'name' => 'Sicurezza',
      'description' => 'Gestione dei reset password e recupero credenziali',
    ],
    'sort' => 4,
    'icon' => 'heroicon-o-key',
  ],
  'label' => 'Password Reset',
  'plural_label' => 'Password Reset (Plurale)',
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
      'label' => 'Crea Password Reset',
    ],
    'edit' => [
      'label' => 'Modifica Password Reset',
    ],
    'delete' => [
      'label' => 'Elimina Password Reset',
    ],
  ],
];
