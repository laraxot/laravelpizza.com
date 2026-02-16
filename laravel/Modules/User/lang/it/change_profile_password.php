<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Password Profilo',
    'plural_label' => 'Password Profilo',
    'group' => 'Profilo',
    'icon' => 'heroicon-o-lock-closed',
    'sort' => 12,
  ),
  'label' => 'Password Profilo',
  'plural_label' => 'Password Profilo',
  'fields' => 
  array (
    'current_password' => 
    array (
      'label' => 'Password Attuale',
      'tooltip' => 'Inserisci la password attuale',
      'placeholder' => 'Inserisci la password attuale',
      'helper_text' => 'La tua password attuale per verificare l\'identità',
      'description' => 'Password corrente dell\'utente',
    ),
    'new_password' => 
    array (
      'label' => 'Nuova Password',
      'tooltip' => 'Inserisci la nuova password',
      'placeholder' => 'Inserisci la nuova password',
      'helper_text' => 'Minimo 8 caratteri con lettere e numeri',
      'description' => 'Nuova password da impostare',
    ),
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
    'save' => 
    array (
      'label' => 'Salva Password',
      'tooltip' => 'Salva la nuova password',
      'helper_text' => 'Aggiorna la password del profilo',
      'description' => 'Azione per salvare',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'tooltip' => 'Annulla l\'operazione',
      'helper_text' => 'Torna indietro senza salvare',
      'description' => 'Azione per annullare',
    ),
  ),
  'messages' => 
  array (
    'password_changed' => 'Password del profilo cambiata con successo',
    'password_mismatch' => 'Le password non coincidono',
    'error' => 'Si è verificato un errore',
  ),
);
