<?php

declare(strict_types=1);

return [
  'fields' => [
    'mailable' => [
      'label' => 'mailable',
    ],
    'subject' => [
      'label' => 'subject',
    ],
    'html_template' => [
      'label' => 'html_template',
    ],
    'text_template' => [
      'label' => 'text_template',
    ],
  ],
  'actions' => [
    'create' => [
      'label' => 'create',
    ],
    'createAnother' => [
      'label' => 'createAnother',
    ],
    'cancel' => [
      'label' => 'cancel',
    ],
  ],
  'label' => 'Create Mail Template',
  'plural_label' => 'Create Mail Template (Plurale)',
  'navigation' => [
    'name' => 'Create Mail Template',
    'plural' => 'Create Mail Template',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Create Mail Template',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
];
