<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'Email',
      'description' => 'Email',
      'helper_text' => '',
      'placeholder' => 'Inserisci la tua email',
      'tooltip' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'description' => 'Password',
      'helper_text' => '',
      'placeholder' => 'Inserisci la tua password',
      'tooltip' => '',
    ),
    'remember' => 
    array (
      'label' => 'Ricordami',
      'description' => 'Ricordami',
      'helper_text' => '',
      'placeholder' => 'Ricordami',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'login' => 
    array (
      'label' => 'Accedi',
      'success' => 'Accesso effettuato con successo',
      'error' => 'Credenziali non valide',
    ),
    'register' => 
    array (
      'label' => 'Registrati',
      'success' => 'Registrazione completata con successo',
      'error' => 'Impossibile completare la registrazione',
    ),
    'forgot_password' => 
    array (
      'label' => 'Password dimenticata?',
      'success' => 'Istruzioni inviate alla tua email',
      'error' => 'Impossibile inviare le istruzioni',
    ),
    'hidePassword' => 
    array (
      'label' => 'Nascondi Password',
      'icon' => 'hidePassword',
      'tooltip' => 'Nascondi Password',
    ),
    'showPassword' => 
    array (
      'label' => 'Mostra Password',
      'icon' => 'showPassword',
      'tooltip' => 'Mostra Password',
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
  'title' => 'Accedi al tuo account',
  'subtitle_start' => 'Oppure',
  'subtitle_link' => 'crea un nuovo account',
  'page' => 
  array (
    'title' => 'Benvenuto a LaravelPizza! 🍕',
    'subtitle' => 'Accedi alla community di developer e pizza lovers',
  ),
  'already_registered' => 'Non hai ancora un account?',
  'register' => 'Registrati ora',
  'no_account' => 'Non hai ancora un account?',
  'register_now' => 'Registrati ora',
  'forgot_password_text' => 'Hai dimenticato la tua password?',
  'reset_it' => 'Reimpostala qui',
);
