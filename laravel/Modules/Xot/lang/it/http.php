<?php

declare(strict_types=1);

return array (
  404 => 
  array (
    'title' => 'Pagina Non Trovata',
    'description' => 'Spiacenti, la pagina che stavi cercando di visualizzare non esiste.',
  ),
  503 => 
  array (
    'title' => 'Torniamo subito.',
    'description' => 'Torniamo subito.',
  ),
  'label' => 'Http',
  'plural_label' => 'Http (Plurale)',
  'navigation' => 
  array (
    'name' => 'Http',
    'plural' => 'Http',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Http',
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
      'label' => 'Crea Http',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Http',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Http',
    ),
  ),
);
