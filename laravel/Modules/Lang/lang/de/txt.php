<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'E-Mail',
      'placeholder' => 'Geben Sie Ihre E-Mail ein',
      'tooltip' => 'Verwenden Sie eine gültige E-Mail-Adresse',
      'icon' => 'heroicon-o-mail',
      'description' => 'email',
      'helper_text' => '',
    ),
    'password' => 
    array (
      'label' => 'Passwort',
      'placeholder' => 'Geben Sie Ihr Passwort ein',
      'tooltip' => 'Das Passwort muss mindestens 8 Zeichen enthalten',
      'icon' => 'heroicon-o-lock-closed',
      'description' => 'password',
      'helper_text' => '',
    ),
    'remember' => 
    array (
      'label' => 'Angemeldet bleiben',
      'tooltip' => 'Halten Sie mich auf diesem Gerät angemeldet',
      'description' => 'remember',
      'helper_text' => '',
      'placeholder' => 'remember',
    ),
  ),
  'actions' => 
  array (
    'authenticate' => 
    array (
      'label' => 'Authentifizieren',
      'tooltip' => 'Im System anmelden',
      'icon' => 'ui-login',
      'color' => 'primary',
    ),
    'login' => 
    array (
      'label' => 'Anmelden',
      'tooltip' => 'Mit Ihren Anmeldedaten anmelden',
      'icon' => 'heroicon-o-key',
      'color' => 'success',
    ),
    'request' => 
    array (
      'label' => 'request',
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
