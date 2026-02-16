<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del permesso',
      'help' => 'Nome univoco del permesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'guard_name' => 
    array (
      'label' => 'Guard Name',
      'placeholder' => 'Inserisci il nome del guard',
      'help' => 'Nome del guard per il permesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'active' => 
    array (
      'label' => 'Attivo',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Indica se il permesso è attivo',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di creazione',
      'help' => 'Data di creazione del permesso',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'common' => 
  array (
    'yes' => 'Sì',
    'no' => 'No',
  ),
  'navigation' => 
  array (
    'sort' => 80,
    'label' => 'Permessi',
    'group' => 'Sicurezza',
    'icon' => 'heroicon-o-shield-check',
  ),
  'label' => 'Permission',
  'plural_label' => 'Permission (Plurale)',
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Permission',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Permission',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Permission',
    ),
  ),
);
