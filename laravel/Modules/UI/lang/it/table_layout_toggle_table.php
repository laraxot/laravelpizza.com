<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'toggle' => 
    array (
      'label' => 'Cambia Layout Tabella',
    ),
  ),
  'table_layout' => 
  array (
    'actions' => 
    array (
      'toggle' => 
      array (
        'label' => 'Cambia Layout',
        'tooltip' => 'Passa da vista a elenco a vista a griglia',
        'helper_text' => 'Cambia il tipo di visualizzazione',
      ),
    ),
  ),
  'fields' => 
  array (
    'layout' => 
    array (
      'label' => 'Layout',
      'placeholder' => 'Seleziona tipo di layout',
      'tooltip' => 'Scegli tra vista a elenco e vista a griglia',
      'help' => 'Scegli il tipo di layout più adatto per visualizzare i dati',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'label' => 'Table Layout Toggle Table',
  'plural_label' => 'Table Layout Toggle Table (Plurale)',
  'navigation' => 
  array (
    'name' => 'Table Layout Toggle Table',
    'plural' => 'Table Layout Toggle Table',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Table Layout Toggle Table',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
);
