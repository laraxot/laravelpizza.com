<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Utente Tenant',
    'plural' => 'Utenti Tenant',
    'label' => 'Utenti Tenant',
    'group' => 
    array (
      'name' => 'Tenants',
      'description' => 'Gestione degli utenti associati ai tenant',
    ),
    'sort' => 87,
    'icon' => 'heroicon-o-building-office',
  ),
  'label' => 'Tenant User',
  'plural_label' => 'Tenant User (Plurale)',
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
      'label' => 'Crea Tenant User',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Tenant User',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Tenant User',
    ),
  ),
);
