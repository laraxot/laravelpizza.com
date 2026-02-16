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
    'name' => 'Password Data',
    'plural' => 'Password Data',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Password Data',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'label' => 'Password Data',
  'plural_label' => 'Password Data (Plurale)',
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Password Data',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Password Data',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Password Data',
    ),
  ),
);
