<?php

declare(strict_types=1);

return [
  'state_transition' => [
    'success' => [
      'title' => 'Transizione Completata',
      'body' => 'Lo stato è stato cambiato a ":state" con successo.',
    ],
    'error' => [
      'title' => 'Errore Transizione',
      'body' => 'Si è verificato un errore durante la transizione di stato: :error',
    ],
  ],
  'label' => 'Notifications',
  'plural_label' => 'Notifications (Plurale)',
  'navigation' => [
    'name' => 'Notifications',
    'plural' => 'Notifications',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Notifications',
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
      'label' => 'Crea Notifications',
    ],
    'edit' => [
      'label' => 'Modifica Notifications',
    ],
    'delete' => [
      'label' => 'Elimina Notifications',
    ],
  ],
];
