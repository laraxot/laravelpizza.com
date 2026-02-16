<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Traduzione',
    'plural' => 'Traduzioni',
    'group' => 
    array (
      'name' => 'Admin',
    ),
  ),
  'pages' => 
  array (
    'create' => 'Nuovo Tecnico',
    'edit' => 'Modifica Tecnico',
    'view' => 'Tecnico',
    'list_technicians' => 
    array (
      'navigation' => 
      array (
        'name' => 'Tecnici',
        'plural' => 'Tecnici',
        'group' => 
        array (
          'name' => 'Gestione Utenti',
        ),
      ),
      'fields' => 
      array (
        'user_name' => 'Nome Utente',
        'name' => 'Nome Utente',
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'email' => 'Email',
        'is_active' => 'Stato account',
        'color' => 'Colore',
        'asset_id_root' => 'Abitazione',
        'asset_id' => 'Asset',
        'type' => 'Tipo',
      ),
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'lang' => 
    array (
      'label' => 'Lingua',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'value' => 
    array (
      'label' => 'Valore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'key' => 
    array (
      'label' => 'Chiave',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'namespace' => 
    array (
      'label' => 'Namespace',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'group' => 
    array (
      'label' => 'Gruppo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'item' => 
    array (
      'label' => 'Elemento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome Utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Stato account',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'color' => 
    array (
      'label' => 'Colore',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'asset_id_root' => 
    array (
      'label' => 'Abitazione',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'asset_id' => 
    array (
      'label' => 'Asset',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'type' => 
    array (
      'label' => 'tipo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'user_name' => 
    array (
      'label' => 'nome utente',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'filters' => 
  array (
    'is_active' => 
    array (
      'all' => 'Tutti i tecnici',
      'active' => 'Solo attivi',
      'inactive' => 'Solo inattivi',
    ),
  ),
  'actions' => 
  array (
    'bulk_activate' => 
    array (
      'cta' => 'Attiva selezionati',
    ),
    'bulk_inactivate' => 
    array (
      'cta' => 'Disattiva selezionati',
    ),
    'is_active_on' => 
    array (
      'cta' => 'Abilita account',
    ),
    'is_active_off' => 
    array (
      'cta' => 'Disabilita account',
    ),
  ),
  'act' => 
  array (
    'publish_item_trans' => 'pubblica modifiche riga',
  ),
  'label' => 'Translation',
  'plural_label' => 'Translation (Plurale)',
);
