<?php

declare(strict_types=1);

return array (
  'actions' => 
  array (
    'select' => 
    array (
      'label' => 'Seleziona',
      'description' => 'Scegli questo studio',
    ),
  ),
  'empty' => 
  array (
    'title' => 'Nessuno studio trovato',
    'description' => 'Non ci sono studi disponibili per la zona selezionata.',
  ),
  'fields' => 
  array (
    'distance' => 
    array (
      'label' => 'Distanza',
      'helper_text' => 'Distanza approssimativa dalla tua posizione',
      'tooltip' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'helper_text' => 'Numero di telefono dello studio',
      'tooltip' => '',
      'description' => '',
    ),
    'specializations' => 
    array (
      'label' => 'Specializzazioni',
      'helper_text' => 'Servizi offerti dallo studio',
      'tooltip' => '',
      'description' => '',
    ),
  ),
  'accessibility' => 
  array (
    'studio_card' => 'Scheda studio, clicca per selezionare',
    'selected_studio' => 'Studio selezionato',
    'select_studio' => 'Premi spazio o invio per selezionare questo studio',
  ),
  'label' => 'Studio Selector',
  'plural_label' => 'Studio Selector (Plurale)',
  'navigation' => 
  array (
    'name' => 'Studio Selector',
    'plural' => 'Studio Selector',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Studio Selector',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
);
