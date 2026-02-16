<?php

declare(strict_types=1);

return array (
  'phone' => 
  array (
    'label' => 'Telefono',
    'icon' => 'heroicon-o-phone',
    'color' => 'text-blue-600 hover:text-blue-800',
    'description' => 'Numero di telefono fisso',
  ),
  'mobile' => 
  array (
    'label' => 'Cellulare',
    'icon' => 'heroicon-o-device-phone-mobile',
    'color' => 'text-blue-500 hover:text-blue-700',
    'description' => 'Numero di telefono mobile',
  ),
  'email' => 
  array (
    'label' => 'Email',
    'icon' => 'heroicon-o-envelope',
    'color' => 'text-green-600 hover:text-green-800',
    'description' => 'Indirizzo email',
  ),
  'pec' => 
  array (
    'label' => 'PEC',
    'icon' => 'heroicon-o-shield-check',
    'color' => 'text-purple-600 hover:text-purple-800',
    'description' => 'Posta Elettronica Certificata',
  ),
  'whatsapp' => 
  array (
    'label' => 'WhatsApp',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'color' => 'text-green-500 hover:text-green-700',
    'description' => 'Numero WhatsApp',
  ),
  'fax' => 
  array (
    'label' => 'Fax',
    'icon' => 'heroicon-o-printer',
    'color' => 'text-gray-600',
    'description' => 'Numero fax',
  ),
  'label' => 'Contact Type Enum',
  'plural_label' => 'Contact Type Enum (Plurale)',
  'navigation' => 
  array (
    'name' => 'Contact Type Enum',
    'plural' => 'Contact Type Enum',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Contact Type Enum',
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
      'label' => 'Crea Contact Type Enum',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Contact Type Enum',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Contact Type Enum',
    ),
  ),
);
