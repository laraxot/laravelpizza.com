<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Réinitialisation de Mot de Passe',
    'group' => 'Sécurité',
    'icon' => 'heroicon-o-key',
    'sort' => 42,
  ),
  'label' => 'Réinitialisation de Mot de Passe',
  'plural_label' => 'Réinitialisations de Mot de Passe',
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
      'label' => 'Jeton',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Créé À',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'resend_email' => 
    array (
      'label' => 'Renvoyer l\'Email',
    ),
    'view_request' => 
    array (
      'label' => 'Voir la Demande',
    ),
  ),
);
