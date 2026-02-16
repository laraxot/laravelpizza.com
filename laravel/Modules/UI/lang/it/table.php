<?php

declare(strict_types=1);

return [
  'columns' => [
    'state_actions' => [
      'label' => 'Azioni Stato',
      'placeholder' => '',
      'helper_text' => 'Azioni disponibili per la transizione di stato',
    ],
  ],
  'label' => 'Table',
  'plural_label' => 'Table (Plurale)',
  'navigation' => [
    'name' => 'Table',
    'plural' => 'Table',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Table',
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
      'label' => 'Crea Table',
    ],
    'edit' => [
      'label' => 'Modifica Table',
    ],
    'delete' => [
      'label' => 'Elimina Table',
    ],
  ],
];
