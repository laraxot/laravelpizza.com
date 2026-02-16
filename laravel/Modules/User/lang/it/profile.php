<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Profilo',
    'plural' => 'Profili',
    'group' => 
    array (
      'label' => 'Gestione Utenti',
      'description' => 'Gestione dei profili utente',
    ),
    'icon' => 'user-profile-animated',
    'sort' => 73,
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
      'help' => 'Indirizzo email dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'help' => 'Numero di telefono dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data di nascita',
      'help' => 'Data di nascita dell\'utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'gender' => 
    array (
      'label' => 'Genere',
      'male' => 'Maschio',
      'female' => 'Femmina',
      'other' => 'Altro',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'help' => 'Stato attivo del profilo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'ente' => 
    array (
      'label' => 'Ente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'matr' => 
    array (
      'label' => 'Matricola',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'photo' => 
    array (
      'label' => 'photo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'edit' => 
    array (
      'label' => 'Modifica',
      'success' => 'Profilo aggiornato con successo!',
      'error' => 'Errore durante l\'aggiornamento del profilo',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'success' => 'Profilo eliminato con successo!',
      'error' => 'Errore durante l\'eliminazione del profilo',
      'tooltip' => 'delete',
      'icon' => 'delete',
    ),
    'layout' => 
    array (
      'tooltip' => 'layout',
      'icon' => 'layout',
      'label' => 'layout',
    ),
    'create' => 
    array (
      'tooltip' => 'create',
      'icon' => 'create',
      'label' => 'create',
    ),
  ),
  'messages' => 
  array (
    'update_success' => 'Profilo aggiornato con successo!',
    'no_permission' => 'Non hai i permessi per modificare questo profilo.',
  ),
  'label' => 'Profile',
  'plural_label' => 'Profile (Plurale)',
);
