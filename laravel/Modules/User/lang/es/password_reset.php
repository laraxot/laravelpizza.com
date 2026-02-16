<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Restablecimiento de Contraseña',
    'group' => 'Seguridad',
    'icon' => 'heroicon-o-key',
    'sort' => 42,
  ),
  'label' => 'Restablecimiento de Contraseña',
  'plural_label' => 'Restablecimientos de Contraseña',
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
      'label' => 'Correo Electrónico',
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
      'label' => 'Creado En',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'resend_email' => 
    array (
      'label' => 'Reenviar Correo',
    ),
    'view_request' => 
    array (
      'label' => 'Ver Solicitud',
    ),
  ),
);
