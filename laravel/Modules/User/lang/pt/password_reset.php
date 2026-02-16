<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Redefinição de Senha',
    'group' => 'Segurança',
    'icon' => 'heroicon-o-key',
    'sort' => 42,
  ),
  'label' => 'Redefinição de Senha',
  'plural_label' => 'Redefinições de Senha',
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
      'label' => 'Criado Em',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'resend_email' => 
    array (
      'label' => 'Reenviar Email',
    ),
    'view_request' => 
    array (
      'label' => 'Ver Solicitação',
    ),
  ),
);
