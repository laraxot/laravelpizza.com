<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Azione Cambia Password',
    'plural_label' => 'Azione Cambia Password',
    'group' => 'Profilo',
    'icon' => 'heroicon-o-lock-closed',
    'sort' => 13,
  ),
  'label' => 'Azione Cambia Password',
  'plural_label' => 'Azione Cambia Password',
  'fields' => 
  array (
    'new_password_confirmation' => 
    array (
      'label' => 'Conferma Nuova Password',
      'tooltip' => 'Ripeti la nuova password per sicurezza',
      'placeholder' => 'Reinserisci la nuova password',
      'helper_text' => 'Devi inserire la stessa password per conferma',
      'description' => 'Digita nuovamente la nuova password per conferma',
      'icon' => 'heroicon-o-lock-closed',
      'color' => 'warning',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Azione',
      'tooltip' => 'Crea una nuova azione',
      'helper_text' => 'Crea una nuova azione di cambio password',
      'description' => 'Azione per creare',
    ),
    'execute' => 
    array (
      'label' => 'Esegui',
      'tooltip' => 'Esegui il cambio password',
      'helper_text' => 'Esegui l\'azione di cambio password',
      'description' => 'Azione per eseguire',
    ),
  ),
  'messages' => 
  array (
    'executed' => 'Password cambiata con successo',
    'error' => 'Si è verificato un errore',
  ),
);
