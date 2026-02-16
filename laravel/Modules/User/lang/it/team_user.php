<?php

declare(strict_types=1);

return [
  'navigation' => [
    'name' => 'Utente Team',
    'plural' => 'Utenti Team',
    'label' => 'Utenti Team',
    'group' => [
      'name' => 'Teams',
      'description' => 'Gestione degli utenti associati ai team',
    ],
    'sort' => 65,
    'icon' => 'heroicon-o-user-group',
  ],
  'label' => 'Team User',
  'plural_label' => 'Team User (Plurale)',
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
      'label' => 'Crea Team User',
    ],
    'edit' => [
      'label' => 'Modifica Team User',
    ],
    'delete' => [
      'label' => 'Elimina Team User',
    ],
  ],
];
