<?php

declare(strict_types=1);

return [
  'fields' => [
    'to' => [
      'label' => 'to',
      'placeholder' => 'to',
      'helper_text' => 'to',
      'description' => 'to',
    ],
    'subject' => [
      'label' => 'subject',
      'placeholder' => 'subject',
      'helper_text' => 'subject',
      'description' => 'subject',
    ],
    'body_html' => [
      'label' => 'body_html',
      'placeholder' => 'body_html',
      'helper_text' => 'body_html',
      'description' => 'body_html',
    ],
  ],
  'actions' => [
    'emailFormActions' => [
      'label' => 'emailFormActions',
    ],
  ],
  'label' => 'Send Email',
  'plural_label' => 'Send Email (Plurale)',
  'navigation' => [
    'name' => 'Send Email',
    'plural' => 'Send Email',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Send Email',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
];
