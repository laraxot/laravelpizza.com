<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome identificativo dell\'elemento',
      'description' => 'Nome dell\'oggetto',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'edit-name' => 
    array (
      'label' => 'Modifica nome',
      'placeholder' => 'Nuovo nome',
      'help' => 'Modifica il nome esistente',
      'description' => 'Azione per modificare il nome',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'change-state' => 
    array (
      'label' => 'Cambia stato',
      'placeholder' => 'Seleziona il nuovo stato',
      'help' => 'Modifica lo stato corrente',
      'description' => 'Azione per cambiare lo stato',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona uno stato',
      'help' => 'Stato attuale dell\'elemento',
      'description' => 'Condizione corrente del sistema',
      'helper_text' => '',
      'tooltip' => '',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'placeholder' => 'Inserisci un messaggio',
      'help' => 'Messaggio informativo',
      'description' => 'Testo del messaggio',
      'helper_text' => '',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'change-state' => 
    array (
      'label' => 'change-state',
      'icon' => 'change-state',
      'tooltip' => 'change-state',
    ),
  ),
  'messages' => 
  array (
    'invalid_state_instance' => 'Istanza di stato non valida',
    'record_not_found' => 'Record non trovato',
    'transition_completed' => 
    array (
      'title' => 'Transizione completata',
      'body' => 'La transizione di stato è stata completata con successo',
    ),
    'transition_error' => 
    array (
      'title' => 'Errore durante la transizione',
    ),
  ),
  'label' => 'Icon State',
  'plural_label' => 'Icon State (Plurale)',
  'navigation' => 
  array (
    'name' => 'Icon State',
    'plural' => 'Icon State',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Icon State',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
);
