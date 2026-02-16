<?php

declare(strict_types=1);

return [
  'actions' => [
    'submit' => [
      'label' => 'submit',
      'icon' => 'submit',
      'tooltip' => 'submit',
    ],
    'cancel' => [
      'label' => 'cancel',
      'icon' => 'cancel',
      'tooltip' => 'cancel',
    ],
  ],
  'label' => 'Send Records Notification Bulk',
  'plural_label' => 'Send Records Notification Bulk (Plurale)',
  'navigation' => [
    'name' => 'Send Records Notification Bulk',
    'plural' => 'Send Records Notification Bulk',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Send Records Notification Bulk',
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
];
