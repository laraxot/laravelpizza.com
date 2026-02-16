<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'toggle' => 
    array (
      'label' => 'Cambia Layout',
      'tooltip' => 'Passa da vista a elenco a vista a griglia',
      'helper_text' => 'Cambia il tipo di visualizzazione',
    ),
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
);
