<?php

declare(strict_types=1);

return [
  'actions' => [
    'route:list' => [
      'label' => 'route:list',
    ],
    'icons:cache' => [
      'label' => 'icons:cache',
    ],
    'filament:cache-components' => [
      'label' => 'filament:cache-components',
    ],
    'filament:clear-cached-components' => [
      'label' => 'filament:clear-cached-components',
    ],
  ],
  'label' => 'Artisan Header',
  'plural_label' => 'Artisan Header (Plurale)',
  'navigation' => [
    'name' => 'Artisan Header',
    'plural' => 'Artisan Header',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Artisan Header',
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
