<?php

declare(strict_types=1);

return array (
  'list' => 
  array (
    'label' => 'Lista',
    'color' => 'primary',
    'icon' => 'heroicon-o-list-bullet',
    'description' => 'Layout a lista tradizionale con righe di tabella',
    'tooltip' => 'Visualizza i dati in formato tabella strutturata',
    'helper_text' => 'Ideale per visualizzare molti dati in modo organizzato',
  ),
  'grid' => 
  array (
    'label' => 'Griglia',
    'color' => 'secondary',
    'icon' => 'heroicon-o-squares-2x2',
    'description' => 'Layout a griglia responsive con card',
    'tooltip' => 'Visualizza i dati in formato card responsive',
    'helper_text' => 'Ideale per visualizzare pochi dati con focus visivo',
  ),
  'label' => 'Table Layout Enum',
  'plural_label' => 'Table Layout Enum (Plurale)',
  'navigation' => 
  array (
    'name' => 'Table Layout Enum',
    'plural' => 'Table Layout Enum',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Table Layout Enum',
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
      'label' => 'Crea Table Layout Enum',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Table Layout Enum',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Table Layout Enum',
    ),
  ),
);
