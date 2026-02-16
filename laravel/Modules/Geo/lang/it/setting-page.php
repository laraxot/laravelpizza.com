<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Impostazioni',
    'group' => 'Gestione Territorio',
    'icon' => 'heroicon-o-cog-6-tooth',
    'sort' => 99,
  ),
  'fields' => 
  array (
    'google_maps_api_key' => 
    array (
      'label' => 'Google Maps API Key',
      'helper' => 'Chiave API per l\'integrazione con Google Maps',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'debugbar_enabled' => 
    array (
      'label' => 'Debug Bar',
      'helper' => 'Abilita/Disabilita la barra di debug',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'save' => 'Salva Impostazioni',
    'reset' => 'Ripristina Predefiniti',
  ),
  'messages' => 
  array (
    'saved' => 'Impostazioni salvate con successo',
    'error' => 'Errore durante il salvataggio delle impostazioni',
  ),
  'label' => 'Setting Page',
  'plural_label' => 'Setting Page (Plurale)',
);
