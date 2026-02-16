<?php

declare(strict_types=1);

return array (
  'field' => 
  array (
    'label' => 'Indirizzi',
    'help' => 
    array (
      'title' => 'Gestione Indirizzi',
      'description' => 'Puoi aggiungere più indirizzi. Con più indirizzi potrai specificare un nome identificativo e designare uno come principale.',
      'primary_note' => 'Solo un indirizzo può essere impostato come principale alla volta.',
    ),
    'actions' => 
    array (
      'add' => 'Aggiungi Indirizzo',
      'remove' => 'Rimuovi Indirizzo',
      'move_up' => 'Sposta Su',
      'move_down' => 'Sposta Giù',
    ),
    'empty_state' => 
    array (
      'title' => 'Nessun indirizzo configurato',
      'description' => 'Inizia aggiungendo il primo indirizzo.',
    ),
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome Indirizzo',
      'placeholder' => 'es. Sede Principale, Filiale Nord, Casa',
      'help' => 'Nome identificativo per questo indirizzo (visibile solo con più indirizzi]',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_primary' => 
    array (
      'label' => 'Indirizzo Principale',
      'help' => 'Designa questo come indirizzo principale (solo uno può essere principale]',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'messages' => 
  array (
    'validation' => 
    array (
      'min_items' => 'È richiesto almeno :min indirizzo/i.',
      'max_items' => 'Non è possibile avere più di :max indirizzi.',
      'primary_required' => 'Almeno un indirizzo deve essere designato come principale.',
    ),
    'success' => 
    array (
      'added' => 'Indirizzo aggiunto con successo.',
      'updated' => 'Indirizzi aggiornati con successo.',
      'removed' => 'Indirizzo rimosso con successo.',
      'primary_set' => 'Indirizzo principale aggiornato.',
    ),
  ),
  'tooltips' => 
  array (
    'name_visibility' => 'Il campo nome è visibile solo quando hai più di un indirizzo',
    'primary_exclusivity' => 'Impostando questo come principale, tutti gli altri diventeranno secondari',
    'single_primary' => 'Con un solo indirizzo, questo è automaticamente il principale',
  ),
  'label' => 'Addresses',
  'plural_label' => 'Addresses (Plurale)',
  'navigation' => 
  array (
    'name' => 'Addresses',
    'plural' => 'Addresses',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Addresses',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Addresses',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Addresses',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Addresses',
    ),
  ),
);
