<?php

declare(strict_types=1);

return [
  'sections' => [
    'Profile Information' => [
      'label' => 'Profile Information',
      'heading' => 'Profile Information',
    ],
    'Update Password' => [
      'label' => 'Update Password',
      'heading' => 'Update Password',
    ],
  ],
  'fields' => [
    'name' => [
      'label' => 'name',
      'placeholder' => 'name',
      'helper_text' => 'name',
      'description' => 'name',
    ],
    'email' => [
      'label' => 'email',
      'placeholder' => 'email',
      'helper_text' => 'email',
      'description' => 'email',
    ],
    'Current password' => [
      'label' => 'Current password',
      'placeholder' => 'Current password',
      'helper_text' => 'Current password',
      'description' => 'Current password',
    ],
    'passwordConfirmation' => [
      'label' => 'passwordConfirmation',
      'placeholder' => 'passwordConfirmation',
      'helper_text' => 'passwordConfirmation',
      'description' => 'passwordConfirmation',
    ],
  ],
  'actions' => [
    'updateProfileAction' => [
      'label' => 'updateProfileAction',
      'icon' => 'updateProfileAction',
      'tooltip' => 'updateProfileAction',
    ],
    'updatePasswordAction' => [
      'label' => 'updatePasswordAction',
      'icon' => 'updatePasswordAction',
      'tooltip' => 'updatePasswordAction',
    ],
  ],
  'navigation' => [
    'name' => 'My Profile',
    'plural' => 'My Profile',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'My Profile',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'My Profile',
  'plural_label' => 'My Profile (Plurale)',
];
