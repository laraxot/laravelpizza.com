<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Passwort-Zurücksetzung',
    'group' => 'Sicherheit',
    'icon' => 'heroicon-o-key',
    'sort' => 42,
  ),
  'label' => 'Passwort-Zurücksetzung',
  'plural_label' => 'Passwort-Zurücksetzungen',
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
      'label' => 'E-Mail',
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
      'label' => 'Erstellt Am',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'resend_email' => 
    array (
      'label' => 'E-Mail Erneut Senden',
    ),
    'view_request' => 
    array (
      'label' => 'Anfrage Anzeigen',
    ),
  ),
);
