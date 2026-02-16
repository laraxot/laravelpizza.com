<?php

declare(strict_types=1);

return [
  'navigation' => [
    'label' => 'Team Invitations',
    'group' => 'Teams',
    'icon' => 'heroicon-o-envelope',
    'sort' => 34,
  ],
  'label' => 'Team Invitation',
  'plural_label' => 'Team Invitation (Plurale)',
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
      'label' => 'Crea Team Invitation',
    ],
    'edit' => [
      'label' => 'Modifica Team Invitation',
    ],
    'delete' => [
      'label' => 'Elimina Team Invitation',
    ],
  ],
];
