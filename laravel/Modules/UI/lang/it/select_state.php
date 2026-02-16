<?php

declare(strict_types=1);

return [
  'fields' => [
    'state' => [
      'label' => 'Stato',
      'placeholder' => 'Seleziona uno stato',
      'help' => 'Stato attuale della selezione',
      'description' => 'Stato selezionabile',
      'helper_text' => '',
    ],
    'message' => [
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci un messaggio',
      'help' => 'Messaggio informativo per la selezione',
      'description' => 'Testo del messaggio',
      'helper_text' => '',
    ],
  ],
  'label' => 'Select State',
  'plural_label' => 'Select State (Plurale)',
  'navigation' => [
    'name' => 'Select State',
    'plural' => 'Select State',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Select State',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'actions' => [
    'create' => [
      'label' => 'Crea Select State',
    ],
    'edit' => [
      'label' => 'Modifica Select State',
    ],
    'delete' => [
      'label' => 'Elimina Select State',
    ],
  ],
];
