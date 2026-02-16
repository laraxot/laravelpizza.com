<?php

declare(strict_types=1);

return [
  'actions' => [
    'toggle' => [
      'label' => 'Cambia Layout',
      'tooltip' => 'Passa da vista a elenco a vista a griglia',
      'helper_text' => 'Cambia il tipo di visualizzazione',
    ],
  ],
  'label' => 'Table Layout',
  'plural_label' => 'Table Layout (Plurale)',
  'navigation' => [
    'name' => 'Table Layout',
    'plural' => 'Table Layout',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Table Layout',
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
