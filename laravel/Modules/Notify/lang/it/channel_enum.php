<?php

declare(strict_types=1);

return array (
  'mail' => 
  array (
    'label' => 'Mail',
  ),
  'sms' => 
  array (
    'label' => 'SMS',
  ),
  'whatsapp' => 
  array (
    'label' => 'WhatsApp',
  ),
  'label' => 'Channel Enum',
  'plural_label' => 'Channel Enum (Plurale)',
  'navigation' => 
  array (
    'name' => 'Channel Enum',
    'plural' => 'Channel Enum',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Channel Enum',
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
      'label' => 'Crea Channel Enum',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Channel Enum',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Channel Enum',
    ),
  ),
);
