<?php

declare(strict_types=1);

return [
  'navigation' => [
    'name' => 'Env',
    'plural' => 'Env',
    'group' => [
      'name' => 'Admin',
    ],
  ],
  'pages' => [
    'health_check_results' => [
      'buttons' => [
        'refresh' => 'Refresh',
      ],
      'heading' => 'Application Health',
      'navigation' => [
        'group' => 'Settings',
        'label' => 'Application Health',
      ],
      'notifications' => [
        'check_results' => 'Check results from',
      ],
    ],
  ],
  'label' => 'Env',
  'plural_label' => 'Env (Plurale)',
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
      'label' => 'Crea Env',
    ],
    'edit' => [
      'label' => 'Modifica Env',
    ],
    'delete' => [
      'label' => 'Elimina Env',
    ],
  ],
];
