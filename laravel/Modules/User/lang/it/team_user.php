<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Utente Team',
    'plural' => 'Utenti Team',
    'label' => 'Utenti Team',
    'group' => 
    array (
      'name' => 'Teams',
      'description' => 'Gestione degli utenti associati ai team',
    ),
    'sort' => 65,
    'icon' => 'heroicon-o-user-group',
  ),
  'label' => 'Team User',
  'plural_label' => 'Team User (Plurale)',
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
      'label' => 'Crea Team User',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Team User',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Team User',
    ),
  ),
);
