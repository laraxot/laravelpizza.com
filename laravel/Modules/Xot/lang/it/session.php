<?php

declare(strict_types=1);

return [
  'navigation' => [
    'name' => 'sessione',
    'plural' => 'sessioni',
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
  'label' => 'Session',
  'plural_label' => 'Session (Plurale)',
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
      'label' => 'Crea Session',
    ],
    'edit' => [
      'label' => 'Modifica Session',
    ],
    'delete' => [
      'label' => 'Elimina Session',
    ],
  ],
];
