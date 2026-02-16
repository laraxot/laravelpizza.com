<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Password Reset',
    'group' => 'Security',
    'icon' => 'heroicon-o-key',
    'sort' => 42,
  ),
  'label' => 'Password Reset',
  'plural_label' => 'Password Resets',
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token' => 
    array (
      'label' => 'Token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'resend_email' => 
    array (
      'label' => 'Resend Email',
    ),
    'view_request' => 
    array (
      'label' => 'View Request',
    ),
  ),
);
