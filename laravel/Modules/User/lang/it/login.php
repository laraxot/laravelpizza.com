<?php

declare(strict_types=1);

return [
  'fields' => [
    'email' => [
      'label' => 'Email',
      'description' => 'Email',
      'helper_text' => '',
      'placeholder' => 'Inserisci la tua email',
    ],
    'password' => [
      'label' => 'Password',
      'description' => 'Password',
      'helper_text' => '',
      'placeholder' => 'Inserisci la tua password',
    ],
    'remember' => [
      'label' => 'Ricordami',
      'description' => 'Ricordami',
      'helper_text' => '',
      'placeholder' => 'Ricordami',
    ],
  ],
  'actions' => [
    'login' => [
      'label' => 'Accedi',
      'success' => 'Accesso effettuato con successo',
      'error' => 'Credenziali non valide',
    ],
    'register' => [
      'label' => 'Registrati',
      'success' => 'Registrazione completata con successo',
      'error' => 'Impossibile completare la registrazione',
    ],
    'forgot_password' => [
      'label' => 'Password dimenticata?',
      'success' => 'Istruzioni inviate alla tua email',
      'error' => 'Impossibile inviare le istruzioni',
    ],
    'hidePassword' => [
      'label' => 'Nascondi Password',
      'icon' => 'hidePassword',
      'tooltip' => 'Nascondi Password',
    ],
    'showPassword' => [
      'label' => 'Mostra Password',
      'icon' => 'showPassword',
      'tooltip' => 'Mostra Password',
    ],
  ],
  'navigation' => [
    'name' => 'Login',
    'plural' => 'Login',
    'group' => [
      'name' => 'General',
      'description' => 'General Settings',
    ],
    'label' => 'Login',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ],
  'label' => 'Login',
  'plural_label' => 'Login (Plurale)',
  'title' => 'Accedi al tuo account',
  'subtitle_start' => 'Oppure',
  'subtitle_link' => 'crea un nuovo account',
  'page' => [
    'title' => 'Benvenuto a LaravelPizza! 🍕',
    'subtitle' => 'Accedi alla community di developer e pizza lovers',
  ],
  'already_registered' => 'Non hai ancora un account?',
  'register' => 'Registrati ora',
  'no_account' => 'Non hai ancora un account?',
  'register_now' => 'Registrati ora',
  'forgot_password_text' => 'Hai dimenticato la tua password?',
  'reset_it' => 'Reimpostala qui',
];
