<?php

declare(strict_types=1);

return array (
  'list' => 
  array (
    'label' => 'Lista',
    'description' => 'Visualizzazione a lista tradizionale',
    'tooltip' => 'Mostra elementi in formato lista',
    'helper_text' => 'Layout tradizionale con righe e colonne',
    'color' => 'primary',
    'icon' => 'heroicon-o-list-bullet',
  ),
  'grid' => 
  array (
    'label' => 'Griglia',
    'description' => 'Visualizzazione a griglia con card',
    'tooltip' => 'Mostra elementi in formato griglia',
    'helper_text' => 'Layout a griglia con card responsive',
    'color' => 'secondary',
    'icon' => 'heroicon-o-squares-2x2',
  ),
  'toggle' => 
  array (
    'label' => 'Cambia Layout',
    'tooltip' => 'Alterna tra visualizzazione lista e griglia',
    'helper_text' => 'Cambia il tipo di visualizzazione',
  ),
  'label' => 'Table Layout',
  'plural_label' => 'Table Layout (Plurale)',
  'navigation' => 
  array (
    'name' => 'Table Layout',
    'plural' => 'Table Layout',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Table Layout',
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
      'label' => 'Crea Table Layout',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Table Layout',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Table Layout',
    ),
  ),
);
