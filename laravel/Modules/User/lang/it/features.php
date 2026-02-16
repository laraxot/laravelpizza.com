<?php

declare(strict_types=1);

return [
  'fields' => [
    'name' => 'Nome',
    'name.placeholder' => 'Inserisci il nome della feature',
    'name.helper_text' => 'Il nome della feature',
    'scope' => 'Ambito',
    'scope.placeholder' => 'Inserisci l\'ambito della feature',
    'scope.helper_text' => 'L\'ambito della feature (es. globale, utente, team]',
    'value' => 'Valore',
    'value.placeholder' => 'Inserisci il valore della feature',
    'value.helper_text' => 'Il valore o la configurazione della feature',
  ],
  'navigation' => [
    'name' => 'Features',
    'plural' => 'Features',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Features',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Features',
  'plural_label' => 'Features (Plurale)',
  'actions' => [
    'create' => [
      'label' => 'Crea Features',
    ],
    'edit' => [
      'label' => 'Modifica Features',
    ],
    'delete' => [
      'label' => 'Elimina Features',
    ],
  ],
];
