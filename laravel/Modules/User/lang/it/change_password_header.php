<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Header Password',
    'plural_label' => 'Header Password',
    'group' => 'Impostazioni',
    'icon' => 'heroicon-o-lock-closed',
    'sort' => 11,
  ),
  'label' => 'Header Password',
  'plural_label' => 'Header Password',
  'fields' => 
  array (
    'new_password_confirmation' => 
    array (
      'label' => 'Conferma Nuova Password',
      'tooltip' => 'Ripeti la nuova password per sicurezza',
      'placeholder' => 'Conferma la tua nuova password',
      'helper_text' => 'Devi inserire la stessa password per conferma',
      'description' => 'Inserisci nuovamente la nuova password per confermarla',
      'icon' => 'heroicon-o-lock-closed',
      'color' => 'warning',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Header',
      'tooltip' => 'Crea un nuovo header per la password',
      'helper_text' => 'Crea un nuovo header',
      'description' => 'Azione per creare',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Header',
      'tooltip' => 'Modifica il header',
      'helper_text' => 'Modifica il header esistente',
      'description' => 'Azione per modificare',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Header',
      'tooltip' => 'Elimina il header',
      'helper_text' => 'Elimina il header',
      'description' => 'Azione per eliminare',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Header creato con successo',
    'updated' => 'Header aggiornato con successo',
    'deleted' => 'Header eliminato con successo',
  ),
);
