<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'view' => 
    array (
      'label' => 'Visualizzazione',
      'tooltip' => 'Seleziona la visualizzazione da mostrare',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'updateAction' => 
    array (
      'label' => 'Aggiorna Footer',
      'tooltip' => 'Aggiorna le impostazioni del footer',
      'icon' => 'heroicon-o-pencil',
      'color' => 'primary',
    ),
  ),
  'label' => 'Footer',
  'plural_label' => 'Footer (Plurale)',
  'navigation' => 
  array (
    'name' => 'Footer',
    'plural' => 'Footer',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Footer',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
);
