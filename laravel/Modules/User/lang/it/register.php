<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Registrazione',
    'plural_label' => 'Registrazione',
    'group' => 'Autenticazione',
    'icon' => 'heroicon-o-user-plus',
    'sort' => 10,
  ),
  'label' => 'Registrazione',
  'plural_label' => 'Registrazione',
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il tuo nome',
      'help' => 'Il tuo nome completo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci la tua email',
      'help' => 'Indirizzo email valido',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Crea una password sicura',
      'help' => 'Minimo 8 caratteri',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Ripeti la password',
      'help' => 'Ripeti la password per conferma',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'register' => 
    array (
      'label' => 'Registrati',
      'tooltip' => 'Crea un nuovo account',
    ),
  ),
  'messages' => 
  array (
    'registered' => 'Registrazione completata con successo',
    'error' => 'Errore durante la registrazione',
  ),
);
