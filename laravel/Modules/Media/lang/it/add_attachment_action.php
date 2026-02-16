<?php

declare(strict_types=1);

return [
  'title' => 'Allegati',
  'label' => 'Carica allegato',
  'fields' => [
    'file' => 'file',
    'file_hint' => '',
    'name' => 'Nome',
    'name_hint' => 'nome del file',
  ],
  'plural_label' => 'Add Attachment Action (Plurale)',
  'navigation' => [
    'name' => 'Add Attachment Action',
    'plural' => 'Add Attachment Action',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Add Attachment Action',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'actions' => [
    'create' => [
      'label' => 'Crea Add Attachment Action',
    ],
    'edit' => [
      'label' => 'Modifica Add Attachment Action',
    ],
    'delete' => [
      'label' => 'Elimina Add Attachment Action',
    ],
  ],
];
