<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la password',
      'help' => 'La password deve essere di almeno 8 caratteri',
      'validation' => 
      array (
        'required' => 'La password è obbligatoria',
        'min' => 'La password deve essere di almeno 8 caratteri',
        'max' => 'La password non può superare i 255 caratteri',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Conferma la password',
      'help' => 'Reinserisci la password per confermare',
      'validation' => 
      array (
        'required' => 'La conferma della password è obbligatoria',
        'min' => 'La password deve essere di almeno 8 caratteri',
        'max' => 'La password non può superare i 255 caratteri',
        'same' => 'Le password non coincidono',
      ),
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
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
  'actions' => 
  array (
  ),
);
