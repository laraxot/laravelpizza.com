<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Team Invitations',
    'group' => 'Teams',
    'icon' => 'heroicon-o-envelope',
    'sort' => 34,
  ),
  'label' => 'Team Invitation',
  'plural_label' => 'Team Invitation (Plurale)',
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
      'label' => 'Crea Team Invitation',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Team Invitation',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Team Invitation',
    ),
  ),
);
