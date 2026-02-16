<?php

declare(strict_types=1);

return array (
  'password' => 'Le password devono essere di almeno 6 caratteri e devono coincidere.',
  'reset' => 'La password è stata reimpostata!',
  'sent' => 'E-mail per il reset della password inviata!',
  'token' => 'Questo token per il reset della password non è valido.',
  'user' => 'Non esiste alcun utente associato a questo indirizzo e-mail.',
  'label' => 'Passwords',
  'plural_label' => 'Passwords (Plurale)',
  'navigation' => 
  array (
    'name' => 'Passwords',
    'plural' => 'Passwords',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Passwords',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Identificativo',
      'tooltip' => 'Identificativo univoco del record',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Passwords',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Passwords',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Passwords',
    ),
  ),
);
