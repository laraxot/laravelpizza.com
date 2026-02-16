<?php

declare(strict_types=1);

return [
  'fields' => [
    'text' => [
      'label' => 'Testo',
      'description' => 'text',
      'placeholder' => 'text',
      'helper_text' => 'text',
    ],
    'level' => [
      'label' => 'Grandezza',
      'description' => 'level',
      'helper_text' => 'level',
      'placeholder' => 'level',
    ],
    '_tpl' => [
      'label' => '_tpl',
    ],
    'view' => [
      'label' => 'view',
      'description' => 'view',
      'helper_text' => 'view',
      'placeholder' => 'view',
    ],
  ],
  'label' => 'Title',
  'plural_label' => 'Title (Plurale)',
  'navigation' => [
    'name' => 'Title',
    'plural' => 'Title',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Title',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'actions' => [
    'create' => [
      'label' => 'Crea Title',
    ],
    'edit' => [
      'label' => 'Modifica Title',
    ],
    'delete' => [
      'label' => 'Elimina Title',
    ],
  ],
];
