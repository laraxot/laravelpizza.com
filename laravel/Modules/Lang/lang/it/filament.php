<?php

declare(strict_types=1);

return array (
  'filters' => 
  array (
    'apply' => 
    array (
      'label' => 'Applica filtri',
      'tooltip' => 'Applica i filtri selezionati',
      'icon' => 'heroicon-o-funnel',
    ),
    'reset' => 
    array (
      'label' => 'Reset filtri',
      'tooltip' => 'Ripristina i filtri predefiniti',
      'icon' => 'heroicon-o-x-mark',
    ),
    'open' => 
    array (
      'label' => 'Apri filtri',
      'tooltip' => 'Mostra i pannelli di filtro',
      'icon' => 'heroicon-o-adjustments-horizontal',
    ),
  ),
  'columns' => 
  array (
    'toggle' => 
    array (
      'label' => 'Mostra/Nascondi colonne',
      'tooltip' => 'Gestisci la visibilità delle colonne',
      'icon' => 'heroicon-o-view-columns',
    ),
  ),
  'records' => 
  array (
    'reorder' => 
    array (
      'label' => 'Riordina record',
      'tooltip' => 'Modifica l\'ordine dei record',
      'icon' => 'heroicon-o-arrows-up-down',
    ),
  ),
  'label' => 'Filament',
  'plural_label' => 'Filament (Plurale)',
  'navigation' => 
  array (
    'name' => 'Filament',
    'plural' => 'Filament',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Filament',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
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
      'label' => 'Crea Filament',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Filament',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Filament',
    ),
  ),
);
