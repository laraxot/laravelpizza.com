<?php

declare(strict_types=1);

return [
  'contact' => [
    'label' => 'Contatto',
    'empty_state' => 'Nessun contatto',
    'verified' => 'Verificato',
    'sms' => 'SMS',
    'email' => 'Email',
    'tooltip' => [
      'type' => 'Tipo',
      'verified' => 'Verificato',
      'sms_sent' => 'SMS inviati',
      'email_sent' => 'Email inviate',
    ],
  ],
  'label' => 'Columns',
  'plural_label' => 'Columns (Plurale)',
  'navigation' => [
    'name' => 'Columns',
    'plural' => 'Columns',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Columns',
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
      'label' => 'Crea Columns',
    ],
    'edit' => [
      'label' => 'Modifica Columns',
    ],
    'delete' => [
      'label' => 'Elimina Columns',
    ],
  ],
];
