<?php

declare(strict_types=1);

return array (
  'name' => 'Login',
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci la tua email',
      'helper_text' => 'Indirizzo email per accedere',
      'tooltip' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la tua password',
      'helper_text' => 'Password di accesso',
      'tooltip' => '',
      'description' => '',
    ),
    'remember' => 
    array (
      'label' => 'Ricordami',
      'helper_text' => 'Mantieni la sessione attiva',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'login' => 
    array (
      'label' => 'Accedi',
      'tooltip' => 'Effettua il login',
    ),
    'forgot_password' => 
    array (
      'label' => 'Password dimenticata?',
      'tooltip' => 'Recupera la password',
    ),
    'register' => 
    array (
      'label' => 'Registrati',
      'tooltip' => 'Crea un nuovo account',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'login' => 'Login effettuato con successo',
    ),
    'error' => 
    array (
      'invalid_credentials' => 'Credenziali non valide',
      'account_locked' => 'Account bloccato',
      'too_many_attempts' => 'Troppi tentativi, riprova più tardi',
    ),
  ),
  'navigation' => 
  array (
    'name' => 'Login Widget',
    'plural' => 'Login Widget',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Login Widget',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'label' => 'Login Widget',
  'plural_label' => 'Login Widget (Plurale)',
);
